<?php

$raiz = sys_get_temp_dir() . '/ccsm_config_' . bin2hex(random_bytes(12));
if (!mkdir($raiz, 0700)) {
    throw new RuntimeException('No se pudo crear el entorno de prueba.');
}
try {
    if (!copy(__DIR__ . '/../config/config.hosting.example.php', $raiz . '/config.php')) {
        throw new RuntimeException('No se pudo copiar la plantilla.');
    }
    $configuracion = [
        'DB_HOST' => 'mysql.example.invalid', 'DB_PORT' => '3307',
        'DB_USER' => 'usuario_prueba', 'DB_PASS' => 'clave_solo_prueba',
        'DB_NAME' => 'ccsm_prueba', 'URL_ROOT' => 'https://ccsm.example.invalid',
    ];
    $prueba = <<<'PHP'
require $argv[1];
if (APP_ENV !== 'production' || DB_HOST !== 'mysql.example.invalid'
    || DB_PORT !== 3307 || DB_USER !== 'usuario_prueba'
    || DB_PASS !== 'clave_solo_prueba' || DB_NAME !== 'ccsm_prueba'
    || URL_ROOT !== 'https://ccsm.example.invalid' || DB_CHARSET !== 'utf8mb4'
    || DEMO_ENABLED !== ($argv[2] === 'demo')) {
    throw new RuntimeException('Configuración cargada incorrectamente.');
}
echo 'OK';
PHP;
    foreach (['normal', 'demo', 'invalida'] as $modo) {
        $datos = $configuracion;
        if ($modo === 'demo') {
            $datos['DEMO_ENABLED'] = true;
        } elseif ($modo === 'invalida') {
            $datos['DB_PORT'] = 70000;
        }
        if (file_put_contents($raiz . '/config.local.php', '<?php return ' . var_export($datos, true) . ';') === false) {
            throw new RuntimeException('No se pudo preparar la configuración de prueba.');
        }
        $salida = [];
        $estado = 0;
        exec(escapeshellarg(PHP_BINARY) . ' -r ' . escapeshellarg($prueba) . ' '
            . escapeshellarg($raiz . '/config.php') . ' ' . escapeshellarg($modo) . ' 2>&1', $salida, $estado);
        if ($modo === 'invalida') {
            if ($estado === 0 || strpos(implode("\n", $salida), 'DB_PORT debe ser un puerto válido.') === false) {
                throw new RuntimeException('Se aceptó un puerto inválido.');
            }
        } elseif ($estado !== 0 || implode("\n", $salida) !== 'OK') {
            throw new RuntimeException('Fallo de configuración: ' . implode("\n", $salida));
        }
    }
} finally {
    foreach (['config.php', 'config.local.php'] as $archivo) {
        if (is_file($raiz . '/' . $archivo)) {
            unlink($raiz . '/' . $archivo);
        }
    }
    rmdir($raiz);
}
echo "OK: configuración privada del hosting, demo opcional y validación del puerto.\n";
