<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../src/Controllers/InformeController.php';

function verificarRegistro($condicion, $mensaje)
{
    if (!$condicion) {
        throw new RuntimeException($mensaje);
    }
}

class RegistroPruebaController extends InformeController
{
    public $datos;
    public function render($vista, $datos = [])
    {
        $this->datos = $datos;
    }
}

$real = Database::getConnection();
$email = 'test-' . bin2hex(random_bytes(12)) . '@example.invalid';
$ids = [];
try {
    foreach ([
        ['demo_nombre' => '', 'demo_email' => $email, 'demo_aviso' => '1'],
        ['demo_nombre' => 'Prueba', 'demo_email' => 'inválido', 'demo_aviso' => '1'],
        ['demo_nombre' => 'Prueba', 'demo_email' => $email],
        ['demo_nombre' => [], 'demo_email' => $email, 'demo_aviso' => '1'],
        ['demo_nombre' => str_repeat('x', 101), 'demo_email' => $email, 'demo_aviso' => '1']
    ] as $entrada) {
        $rechazada = false;
        try {
            RegistroDemo::validarVisitante($entrada);
        } catch (InvalidArgumentException $e) {
            $rechazada = true;
        }
        verificarRegistro($rechazada, 'Se acepta identidad inválida o sin aviso.');
    }
    $visitante = RegistroDemo::validarVisitante([
        'demo_nombre' => ' Visitante de prueba ', 'demo_email' => strtoupper($email), 'demo_aviso' => '1'
    ]);
    verificarRegistro($visitante['email'] === $email && $visitante['nombre'] === 'Visitante de prueba', 'Normalización incorrecta.');
    $consultar = $real->prepare('SELECT * FROM demo_usos WHERE id = :id');
    for ($i = 0; $i < 2; $i++) {
        Demo::iniciar($visitante);
        $id = $_SESSION['demo']['registro_id'];
        $ids[] = $id;
        verificarRegistro((int) Database::getConnection()->query('SELECT COUNT(*) FROM demo_usos')->fetchColumn() === 0, 'Se expone seguimiento real dentro de la base demo.');
        $controller = new RegistroPruebaController();
        $controller->demo();
        verificarRegistro(http_response_code() === 403 && !isset($controller->datos['registro']), 'La demo puede consultar visitantes reales.');
        if ($i === 1) {
            $_SESSION['demo']['expira'] = time() - 1;
        }
        Demo::terminar();
        RegistroDemo::sugerencias($id, $i === 0 ? '<script>prueba</script>' : '');
        RegistroDemo::sugerencias($id, 'No debe sobrescribir una respuesta');
        $consultar->execute(['id' => $id]);
        $fila = $consultar->fetch();
        verificarRegistro($fila['estado'] === ($i === 0 ? 'finalizada' : 'caducada'), 'No se registra el final de la visita.');
        verificarRegistro($fila['sugerencias'] === ($i === 0 ? '<script>prueba</script>' : null), 'Respuesta opcional o idempotencia incorrecta.');
    }
    $_SESSION = ['perfil_id' => 1];
    $informe = RegistroDemo::informe(1);
    $filas = array_values(array_filter($informe['filas'], static function ($fila) use ($email) { return $fila['email'] === $email; }));
    verificarRegistro(count($filas) === 2 && (int) $filas[0]['usos_visitante'] === 2 && (int) $filas[0]['numero_visita'] === 2, 'No se reconocen visitas repetidas.');
    $registro = $informe;
    ob_start();
    include __DIR__ . '/../src/Views/informes/demo.php';
    $html = ob_get_clean();
    verificarRegistro(strpos($html, '&lt;script&gt;prueba&lt;/script&gt;') !== false && strpos($html, '<script>prueba</script>') === false, 'Las sugerencias no se escapan.');
    $_SESSION = ['perfil_id' => 2];
    $controller = new RegistroPruebaController();
    $controller->demo();
    verificarRegistro(http_response_code() === 403 && !isset($controller->datos['registro']), 'Un usuario no administrador consulta visitantes.');
} finally {
    if (Demo::activa()) {
        Demo::terminar();
    }
    $delete = $real->prepare('DELETE FROM demo_usos WHERE email = :email');
    $delete->execute(['email' => $email]);
    $_SESSION = [];
}
echo "OK: validación, repeticiones, sugerencias, caducidad, privacidad y escape de contenido.\n";
