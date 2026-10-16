<?php

$archivoLocal = __DIR__ . '/config.local.php';
if (!is_file($archivoLocal)) {
    throw new RuntimeException('Falta config/config.local.php con la configuración del hosting.');
}

$configuracion = require $archivoLocal;
if (!is_array($configuracion)) {
    throw new RuntimeException('config/config.local.php debe devolver un array de configuración.');
}

foreach (['DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME', 'URL_ROOT'] as $clave) {
    if (!isset($configuracion[$clave]) || !is_string($configuracion[$clave])) {
        throw new RuntimeException('Falta un valor de texto válido para ' . $clave . ' en config/config.local.php.');
    }
}
foreach (['DB_HOST', 'DB_USER', 'DB_NAME'] as $clave) {
    if (trim($configuracion[$clave]) === '') {
        throw new RuntimeException('El valor de ' . $clave . ' no puede estar vacío.');
    }
}

$puerto = filter_var($configuracion['DB_PORT'] ?? 3306, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 65535],
]);
if ($puerto === false) {
    throw new RuntimeException('DB_PORT debe ser un puerto válido.');
}
if (isset($configuracion['DEMO_ENABLED']) && !is_bool($configuracion['DEMO_ENABLED'])) {
    throw new RuntimeException('DEMO_ENABLED debe ser true o false, sin comillas.');
}
$charset = $configuracion['DB_CHARSET'] ?? 'utf8mb4';
if (!is_string($charset) || !preg_match('/^[a-zA-Z0-9_]+$/D', $charset)) {
    throw new RuntimeException('DB_CHARSET no es válido.');
}

define('APP_ENV', 'production');
define('ROOT_PATH', dirname(__DIR__));
define('DEMO_ENABLED', $configuracion['DEMO_ENABLED'] ?? false);
foreach (['DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME', 'URL_ROOT'] as $clave) {
    define($clave, $configuracion[$clave]);
}
define('DB_PORT', $puerto);
define('DB_CHARSET', $charset);
unset($configuracion, $archivoLocal, $clave, $puerto, $charset);
