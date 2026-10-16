<?php

$raiz = sys_get_temp_dir() . '/ccsm_arranque_' . bin2hex(random_bytes(12));
$archivos = [
    'public/index.php', 'config/config.php', 'config/database.php',
    'core/Demo.php', 'core/AnaliticaDemo.php', 'src/Models/RegistroDemo.php',
    'core/Router.php',
];
$carpetas = ['public', 'config', 'core', 'src', 'src/Models', 'sessions_temp', 'logs'];

try {
    if (!mkdir($raiz, 0700)) {
        throw new RuntimeException('No se pudo crear el entorno de prueba.');
    }
    foreach ($carpetas as $carpeta) {
        if (!mkdir($raiz . '/' . $carpeta, 0700)) {
            throw new RuntimeException('No se pudo crear una carpeta de prueba.');
        }
    }
    foreach (['public/index.php', 'core/Demo.php', 'core/AnaliticaDemo.php', 'src/Models/RegistroDemo.php'] as $archivo) {
        if (!copy(__DIR__ . '/../' . $archivo, $raiz . '/' . $archivo)) {
            throw new RuntimeException('No se pudo copiar el código de prueba.');
        }
    }
    $config = "<?php\ndefine('APP_ENV', 'production');\ndefine('ROOT_PATH', dirname(__DIR__));\n"
        . "\$_SERVER['REQUEST_METHOD'] = 'GET';\n";
    $router = <<<'PHP'
<?php
class Router
{
    public function __construct()
    {
        if (!class_exists('Demo', false) || !class_exists('AnaliticaDemo', false) || Demo::activa()) {
            throw new RuntimeException('Dependencias de arranque incorrectas.');
        }
        echo "OK: dependencias de arranque cargadas.\n";
        exit;
    }
}
PHP;
    if (file_put_contents($raiz . '/config/config.php', $config) === false
        || file_put_contents($raiz . '/core/Router.php', $router) === false) {
        throw new RuntimeException('No se pudo preparar el arranque de prueba.');
    }
    foreach ([
        '<?php class Database {}',
        "<?php require_once __DIR__ . '/../core/Demo.php'; require_once __DIR__ . '/../core/AnaliticaDemo.php'; class Database {}",
    ] as $database) {
        if (file_put_contents($raiz . '/config/database.php', $database) === false) {
            throw new RuntimeException('No se pudo preparar el conector de prueba.');
        }
        $salida = [];
        $estado = 0;
        exec(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($raiz . '/public/index.php') . ' 2>&1', $salida, $estado);
        if ($estado !== 0 || implode("\n", $salida) !== 'OK: dependencias de arranque cargadas.') {
            throw new RuntimeException('Fallo de arranque: ' . implode("\n", $salida));
        }
    }
} finally {
    foreach (array_merge($archivos, ['logs/php_errors.log'], glob($raiz . '/sessions_temp/*') ?: []) as $archivo) {
        $ruta = strpos($archivo, $raiz . '/') === 0 ? $archivo : $raiz . '/' . $archivo;
        if (is_file($ruta)) {
            unlink($ruta);
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
echo "OK: arranque con conector antiguo y actual, sin acceder a la base de datos.\n";
