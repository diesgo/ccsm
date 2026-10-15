<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../core/Instalador.php';

function verificarInstalador($condicion, $mensaje)
{
    if (!$condicion) {
        throw new RuntimeException($mensaje);
    }
}

$token = bin2hex(random_bytes(12));
$raiz = sys_get_temp_dir() . '/ccsm_instalador_test_' . $token;
$base = 'ccsm_instalador_test_' . $token;
$servidor = Database::conectarServidor();
$carpetas = ['config', 'logs', 'sessions_temp', 'public', 'public/uploads', 'public/uploads/socios', 'public/uploads/productos'];
$datos = [
    'host' => DB_HOST, 'puerto' => (string) (defined('DB_PORT') ? DB_PORT : 3306),
    'base' => $base, 'usuario_db' => DB_USER, 'clave_db' => DB_PASS,
    'url' => '/ccsm', 'nombre' => 'Admin de prueba', 'email' => 'admin@example.invalid',
    'usuario_admin' => 'admin-prueba', 'clave_admin' => "prueba-'segura\\123", 'clave_confirmacion' => "prueba-'segura\\123",
    'confirmar' => '1'
];
$configReal = hash_file('sha256', ROOT_PATH . '/config/config.php');
try {
    verificarInstalador(mkdir($raiz, 0700), 'No se pudo crear raíz de prueba.');
    foreach ($carpetas as $carpeta) {
        verificarInstalador(mkdir($raiz . '/' . $carpeta, 0700), 'No se pudo crear carpeta de prueba.');
    }
    verificarInstalador(copy(ROOT_PATH . '/schema_produccion.sql', $raiz . '/schema_produccion.sql'), 'No se pudo copiar el esquema.');
    $instalador = new Instalador($raiz);
    verificarInstalador(!in_array(false, $instalador->requisitos(), true), 'Requisitos incumplidos.');
    foreach ([
        ['base' => 'base`invalida'], ['host' => 'localhost;dbname=otra'],
        ['puerto' => '70000'], ['url' => 'javascript:alert(1)'],
        ['email' => 'invalido'], ['clave_confirmacion' => 'distinta'], ['confirmar' => '0']
    ] as $invalido) {
        $rechazado = false;
        try {
            Instalador::validar(array_replace($datos, $invalido));
        } catch (InvalidArgumentException $e) {
            $rechazado = true;
        }
        verificarInstalador($rechazado, 'Datos inválidos aceptados.');
    }
    $servidor->exec("CREATE DATABASE `$base`");
    $servidor->exec("CREATE TABLE `$base`.sentinela (id INT)");
    $servidor->exec("INSERT INTO `$base`.sentinela VALUES (123)");
    $rechazado = false;
    try {
        $instalador->instalar($datos);
    } catch (RuntimeException $e) {
        $rechazado = strpos($e->getMessage(), 'contiene tablas') !== false;
    }
    verificarInstalador($rechazado && (int) $servidor->query("SELECT id FROM `$base`.sentinela")->fetchColumn() === 123, 'La base no vacía no queda protegida.');
    verificarInstalador(!is_file($raiz . '/config/config.php'), 'Se generó configuración para una base rechazada.');
    $servidor->exec("DROP TABLE `$base`.sentinela");
    verificarInstalador($instalador->instalar($datos) === '/ccsm', 'URL incorrecta.');
    verificarInstalador($instalador->bloqueado() && is_file($raiz . '/config/installed.lock'), 'Falta protección de reinstalación.');
    $admin = $servidor->query("SELECT * FROM `$base`.users")->fetch();
    verificarInstalador($admin['username'] === 'admin-prueba' && (int) $admin['perfil_id'] === 1
        && password_verify($datos['clave_admin'], $admin['password']), 'Administrador incorrecto.');
    foreach (['socios', 'productos', 'compras', 'ventas', 'demo_usos'] as $tabla) {
        verificarInstalador((int) $servidor->query("SELECT COUNT(*) FROM `$base`.`$tabla`")->fetchColumn() === 0, 'Datos de negocio inesperados.');
    }
    verificarInstalador(strpos(file_get_contents($raiz . '/config/config.php'), "define('APP_ENV', 'production')") !== false, 'No se genera configuración de producción.');
    $lint = [];
    $estado = 0;
    exec(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($raiz . '/config/config.php'), $lint, $estado);
    verificarInstalador($estado === 0, 'Configuración generada con sintaxis inválida.');
    unlink($raiz . '/config/installed.lock');
    verificarInstalador($instalador->bloqueado(), 'La configuración por sí sola no protege la instalación.');
    $rechazado = false;
    try {
        $instalador->instalar($datos);
    } catch (RuntimeException $e) {
        $rechazado = strpos($e->getMessage(), 'Ya existe') !== false;
    }
    verificarInstalador($rechazado, 'Se permite sobrescribir la configuración.');
    verificarInstalador(hash_file('sha256', ROOT_PATH . '/config/config.php') === $configReal, 'Se alteró la configuración real.');
} finally {
    $servidor->exec("DROP DATABASE IF EXISTS `$base`");
    foreach (['config/config.php', 'config/installed.lock', 'config/instalacion.lock', 'schema_produccion.sql'] as $archivo) {
        if (is_file($raiz . '/' . $archivo)) {
            unlink($raiz . '/' . $archivo);
        }
    }
    foreach (array_reverse($carpetas) as $carpeta) {
        if (is_dir($raiz . '/' . $carpeta)) {
            rmdir($raiz . '/' . $carpeta);
        }
    }
    if (is_dir($raiz)) {
        rmdir($raiz);
    }
}
echo "OK: instalador, validación, esquema, administrador y protección de datos existentes.\n";
