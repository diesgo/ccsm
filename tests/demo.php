<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../src/Models/Categoria.php';
require __DIR__ . '/../src/Models/Venta.php';

function comprobar($condicion, $mensaje)
{
    if (!$condicion) {
        throw new RuntimeException($mensaje);
    }
}

function huella(PDO $db)
{
    $datos = [];
    foreach (['users', 'socios', 'productos', 'categorias', 'ventas', 'configuracion_sistema'] as $tabla) {
        $datos[$tabla] = $db->query("SELECT * FROM `$tabla`")->fetchAll();
    }
    return hash('sha256', serialize($datos));
}

$real = Database::getConnection();
$antes = huella($real);
$carpetaReal = Demo::carpetaImagenes('socios');
$dirDemo = null;
$baseDemo = null;
try {
    Demo::iniciar();
    $db = Database::getConnection();
    $baseDemo = $db->query('SELECT DATABASE()')->fetchColumn();
    comprobar($baseDemo !== DB_NAME, 'La demo utiliza la base real.');
    comprobar((int) $db->query('SELECT COUNT(*) FROM socios')->fetchColumn() === 2, 'Faltan socios ficticios.');
    comprobar((int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn() === 1, 'Se copiaron usuarios reales.');
    comprobar(Categoria::save('Solo demo', 1, 2, 'bi-leaf'), 'No se puede crear una categoría demo.');
    comprobar(Venta::procesar(1, 1, 2, 3) === true, 'No se puede cobrar en demo.');
    comprobar((float) $db->query('SELECT saldo FROM socios WHERE id_socio = 1')->fetchColumn() === 97.0, 'No se descontó el saldo demo.');
    comprobar((float) $db->query('SELECT dispensario FROM productos WHERE id_producto = 1')->fetchColumn() === 98.0, 'No se descontó el stock demo.');
    $venta = $db->query('SELECT id_venta FROM ventas')->fetchColumn();
    comprobar(Venta::anular($venta) === true, 'No se puede anular en demo.');
    $dirDemo = dirname(rtrim(Demo::carpetaImagenes('socios'), '/'));
    comprobar(Demo::carpetaImagenes('socios') !== $carpetaReal, 'La demo usa las fotos reales.');
    comprobar(file_put_contents(Demo::carpetaImagenes('socios') . 'prueba.txt', 'demo') !== false, 'No se puede escribir en fotos demo.');
    comprobar(strpos(Demo::urlImagen('socios', 'prueba.png'), '/demo/imagen?') !== false, 'La URL de imagen demo no está aislada.');
    comprobar(huella($real) === $antes, 'La demo modificó datos reales.');
    $_SESSION['demo']['expira'] = time() - 1;
    $rechazada = false;
    try {
        Database::getConnection();
    } catch (RuntimeException $e) {
        $rechazada = true;
    }
    comprobar($rechazada, 'Una demo caducada puede acceder a la base de datos.');
} finally {
    if (Demo::activa()) {
        Demo::terminar();
    }
}
comprobar(!is_dir($dirDemo), 'No se eliminaron los archivos demo.');
$stmt = Database::conectarServidor()->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = :nombre');
$stmt->execute(['nombre' => $baseDemo]);
comprobar((int) $stmt->fetchColumn() === 0, 'No se eliminó la base demo.');
comprobar(huella($real) === $antes, 'La limpieza modificó datos reales.');
echo "OK: datos ficticios, CRUD, cobro/anulación, aislamiento, caducidad y limpieza.\n";
