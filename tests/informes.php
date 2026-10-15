<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../src/Controllers/InformeController.php';

function verificarInforme($condicion, $mensaje)
{
    if (!$condicion) {
        throw new RuntimeException($mensaje);
    }
}

class InformePruebaController extends InformeController
{
    public $datos;
    public function render($vista, $datos = [])
    {
        $this->datos = $datos;
    }
}

Demo::iniciar();
try {
    $db = Database::getConnection();
    $db->exec("INSERT INTO ventas (socio_id, producto_id, cantidad, total, date_add_venta) VALUES
        (1, 1, 2, 3, '2026-10-01 00:00:00'),
        (1, 3, 10, 0.5, '2026-10-01 23:59:59'),
        (2, 1, 1, 1.5, '2026-10-02 00:00:00')");
    $db->exec("INSERT INTO compras (proveedor_id, producto_id, pcm, unidades, iva, subtotal, total, date_compra)
        VALUES (1, 1, 0.5, 20, 21, 10, 12.1, '2026-10-01 12:00:00')");
    $base = ['desde' => '2026-10-01', 'hasta' => '2026-10-01'];
    foreach (Informe::TIPOS as $tipo => $nombre) {
        $filtros = Informe::filtros($base + ['tipo' => $tipo]);
        $informe = Informe::obtener($filtros);
        verificarInforme((float) $informe['totales']['importe'] === ($tipo === 'compras' ? 12.1 : 3.5), 'Importe o fecha final incorrectos');
        verificarInforme((int) $informe['totales']['operaciones'] === ($tipo === 'compras' ? 1 : 2), 'Número de líneas incorrecto');
        if ($tipo !== 'compras') {
            verificarInforme((float) $informe['totales']['unidades'] === 2.0 && (float) $informe['totales']['gramos'] === 10.0, 'Mezcla de cantidades');
        }
        $opciones = Informe::opciones();
        ob_start();
        include __DIR__ . '/../src/Views/informes/index.php';
        $html = ob_get_clean();
        verificarInforme(strpos($html, 'No hay operaciones') === false, 'No se renderizan los datos');
        verificarInforme(strpos($html, $nombre) !== false, 'Tipo de informe incorrecto');
    }
    $filtrado = Informe::obtener(Informe::filtros($base + ['producto' => 1, 'socio' => 1]));
    verificarInforme($filtrado['registros'] === 1 && (float) $filtrado['totales']['importe'] === 3.0, 'Filtros de producto/socio incorrectos');
    $vacio = Informe::obtener(Informe::filtros(['desde' => '2020-01-01', 'hasta' => '2020-01-01']));
    verificarInforme($vacio['registros'] === 0 && (float) $vacio['totales']['importe'] === 0.0, 'Informe vacío incorrecto');
    $insert = $db->prepare("INSERT INTO ventas (socio_id, producto_id, cantidad, total, date_add_venta) VALUES (1, 1, 1, 1, '2026-10-03 12:00:00')");
    for ($i = 0; $i < 51; $i++) {
        $insert->execute();
    }
    $pagina = Informe::obtener(Informe::filtros(['desde' => '2026-10-03', 'pagina' => 2]));
    verificarInforme($pagina['registros'] === 51 && count($pagina['filas']) === 1 && (float) $pagina['totales']['importe'] === 51.0, 'Totales o paginación incorrectos');
    foreach ([['desde' => '2026-02-30'], ['desde' => "2026-01-\0" . '01'], ['hasta' => "2026-\0" . '01-01'], ['desde' => '2026-1-01'], ['desde' => '2026-10-02', 'hasta' => '2026-10-01'], ['tipo' => 'inventado'], ['producto' => '1 OR 1=1'], ['pagina' => 0], ['socio' => []]] as $entrada) {
        $rechazado = false;
        try {
            Informe::filtros($entrada);
        } catch (InvalidArgumentException $e) {
            $rechazado = true;
        }
        verificarInforme($rechazado, 'Filtro inválido aceptado');
    }
    $controller = new InformePruebaController();
    $_GET = ['tipo' => 'socios'];
    $controller->index();
    verificarInforme(isset($controller->datos['informe']), 'El administrador demo no puede consultar');
    $_SESSION['perfil_id'] = 5;
    ob_start();
    $controller->index();
    $denegado = ob_get_clean();
    verificarInforme(http_response_code() === 403 && strpos($denegado, 'Acceso restringido') !== false, 'Un no administrador accede al informe');
    echo "OK: cuatro informes, filtros, fechas inclusivas, cantidades separadas, totales, paginación y acceso.\n";
} finally {
    Demo::terminar();
}
