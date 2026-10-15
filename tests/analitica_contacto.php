<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../src/Models/Contacto.php';
require __DIR__ . '/../src/Controllers/DemoController.php';
require __DIR__ . '/../src/Controllers/ContactoController.php';

class ContactoPruebaController extends ContactoController
{
    public $datos;
    public function render($vista, $datos = [])
    {
        $this->datos = $datos;
    }
}

function verificarAnalitica($condicion, $mensaje)
{
    if (!$condicion) {
        throw new RuntimeException($mensaje);
    }
}

$real = Database::getConnection();
$email = 'test-analitica-' . bin2hex(random_bytes(12)) . '@example.invalid';
$datos = ['nombre' => 'Prueba', 'email' => $email, 'tema' => 'idea', 'mensaje' => '<script>idea de prueba</script>', 'aviso' => '1'];
try {
    verificarAnalitica(AnaliticaDemo::ruta('socios/editar', 'GET') === ['seccion' => 'socios', 'accion' => 'abrir_formulario'], 'Ruta de formulario incorrecta.');
    verificarAnalitica(AnaliticaDemo::ruta('contacto', 'POST') === null, 'Se registra contenido de contacto como negocio.');
    verificarAnalitica(AnaliticaDemo::ruta('socios/dato-personal', 'GET') === null, 'La analítica acepta rutas fuera de la lista cerrada.');
    verificarAnalitica(AnaliticaDemo::ruta('productos/editar/123', 'GET') === null, 'Se registran identificadores en rutas.');
    verificarAnalitica(AnaliticaDemo::ruta('roles', 'GET')['seccion'] === 'perfiles', 'Alias no normalizado.');
    foreach ([['facilidad' => '6'], ['facilidad' => []], ['instalaria' => 'otro']] as $entrada) {
        $rechazado = false;
        try { RegistroDemo::valorar($entrada); } catch (InvalidArgumentException $e) { $rechazado = true; }
        verificarAnalitica($rechazado, 'Valoración inválida aceptada.');
    }
    foreach ([['email' => 'invalido'], ['mensaje' => ' '], ['tema' => 'otro'], ['aviso' => '0'], ['mensaje' => []]] as $entrada) {
        $rechazado = false;
        try { Contacto::validar(array_replace($datos, $entrada)); } catch (InvalidArgumentException $e) { $rechazado = true; }
        verificarAnalitica($rechazado, 'Contacto inválido aceptado.');
    }
    Demo::iniciar(['nombre' => 'Prueba', 'email' => $email]);
    $id = $_SESSION['demo']['registro_id'];
    RegistroDemo::evento($id, 'productos', 'guardar', 'ok');
    RegistroDemo::evento($id, 'dispensario', 'cobrar', 'error');
    $controller = new DemoController();
    $_SESSION['demo_actividad_csrf'] = 'token-de-prueba';
    $_SESSION['demo_actividad_tiempo'] = time() - 1000;
    $_POST = ['csrf' => 'token-de-prueba'];
    ob_start();
    $controller->actividad();
    $respuesta = json_decode(ob_get_clean(), true);
    verificarAnalitica($respuesta['success'], 'No se registra actividad.');
    $consulta = $real->prepare('SELECT segundos_activos FROM demo_usos WHERE id = :id');
    $consulta->execute(['id' => $id]);
    verificarAnalitica((int) $consulta->fetchColumn() === 35, 'Un intervalo sin actividad se contabiliza sin límite.');
    $_POST = ['csrf' => 'falso'];
    ob_start();
    $controller->actividad();
    ob_end_clean();
    verificarAnalitica(http_response_code() === 403, 'Actividad sin autorización aceptada.');
    Contacto::guardar(Contacto::validar($datos));
    verificarAnalitica((int) Database::getConnection()->query('SELECT COUNT(*) FROM contacto_mensajes')->fetchColumn() === 0, 'Contactos reales dentro de la base demo.');
    $rechazado = false;
    try { Contacto::bandeja(1); } catch (RuntimeException $e) { $rechazado = true; }
    verificarAnalitica($rechazado, 'La demo accede a la bandeja real.');
    $contactoController = new ContactoPruebaController();
    $contactoController->bandeja();
    verificarAnalitica(http_response_code() === 403 && !isset($contactoController->datos['bandeja']), 'La URL de bandeja expone mensajes a demo.');
    Demo::terminar();
    RegistroDemo::sugerencias($id, '', RegistroDemo::valorar(['facilidad' => '5', 'instalaria' => 'si']));
    $_SESSION = ['user_id' => 1, 'perfil_id' => 1];
    $registro = RegistroDemo::informe(1);
    $visita = array_values(array_filter($registro['filas'], static function ($fila) use ($id) { return $fila['id'] == $id; }))[0];
    verificarAnalitica((int) $visita['facilidad'] === 5 && $visita['instalaria'] === 'si', 'No se guarda valoración.');
    verificarAnalitica(count($registro['eventos'][$id]) === 2, 'Falta recorrido de visita.');
    verificarAnalitica($registro['eventos'][$id][1]['resultado'] === 'error', 'No se registra un error.');
    $bandeja = Contacto::bandeja(1);
    $mensaje = array_values(array_filter($bandeja['filas'], static function ($fila) use ($email) { return $fila['email'] === $email; }))[0];
    verificarAnalitica(!$mensaje['leido'], 'Nuevo contacto marcado leído.');
    Contacto::leido($mensaje['id']);
    $_SESSION['contacto_admin_csrf'] = 'token-admin';
    $_POST = ['csrf' => 'incorrecto', 'id' => (string) $mensaje['id']];
    $contactoController->leido();
    verificarAnalitica(http_response_code() === 403, 'Se permite marcar un contacto sin CSRF.');
    $_POST = ['csrf' => 'token-admin', 'id' => '0'];
    http_response_code(200);
    $contactoController->leido();
    verificarAnalitica(http_response_code() === 400, 'Se permite ID de contacto inválido.');
    $bandeja = Contacto::bandeja(1);
    ob_start();
    include __DIR__ . '/../src/Views/contacto/bandeja.php';
    $html = ob_get_clean();
    verificarAnalitica(strpos($html, '&lt;script&gt;idea de prueba&lt;/script&gt;') !== false
        && strpos($html, '<script>idea de prueba</script>') === false, 'Mensaje de contacto sin escapar.');
    $_SESSION = ['user_id' => 2, 'perfil_id' => 2];
    $rechazado = false;
    try { Contacto::leido($mensaje['id']); } catch (RuntimeException $e) { $rechazado = true; }
    verificarAnalitica($rechazado, 'Un no administrador modifica mensajes.');
} finally {
    if (Demo::activa()) { Demo::terminar(); }
    foreach (['demo_usos', 'contacto_mensajes'] as $tabla) {
        $stmt = $real->prepare("DELETE FROM `$tabla` WHERE email = :email");
        $stmt->execute(['email' => $email]);
    }
    $_SESSION = [];
}
echo "OK: analítica sin contenido, actividad limitada, valoraciones, contacto privado y escape.\n";
