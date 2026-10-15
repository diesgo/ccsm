<?php
session_save_path(__DIR__ . '/../sessions_temp');
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';

$email = 'test-caducidad-' . bin2hex(random_bytes(12)) . '@example.invalid';
$real = Database::getConnection();
$invalido = ($argv[1] ?? '') === 'invalido';
$contacto = ($argv[1] ?? '') === 'contacto';
$completada = false;
register_shutdown_function(static function () use ($email, $real, &$completada) {
    if (Demo::activa()) {
        Demo::terminar();
    }
    $stmt = $real->prepare('DELETE FROM demo_usos WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $stmt = $real->prepare('DELETE FROM contacto_mensajes WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    if (!$completada) {
        throw new RuntimeException('La petición terminó sin verificar las sugerencias tras caducar.');
    }
});
Demo::iniciar(['nombre' => 'Prueba de caducidad', 'email' => $email]);
$id = $_SESSION['demo']['registro_id'];
$_SESSION['demo']['expira'] = time() - 1;
$_SESSION['demo_salida_csrf'] = bin2hex(random_bytes(24));
$_POST = ['accion' => 'enviar', 'csrf' => $invalido ? 'incorrecto' : $_SESSION['demo_salida_csrf'], 'sugerencias' => 'Conservar esta respuesta al caducar'];
$_GET = ['url' => 'demo/salir'];
if ($contacto) {
    $_SESSION['contacto_csrf'] = 'contacto-prueba';
    $_POST = ['nombre' => '', 'email' => $email, 'tema' => 'idea', 'mensaje' => 'Contacto que caduca',
        'aviso' => '1', 'web' => '', 'csrf' => 'contacto-prueba'];
    $_GET = ['url' => 'contacto'];
}
$_SERVER['REQUEST_METHOD'] = 'POST';
session_write_close();
ob_start();
require ROOT_PATH . '/public/index.php';
$salida = ob_get_clean();
$stmt = $real->prepare('SELECT estado, sugerencias, sugerencias_fecha FROM demo_usos WHERE id = :id');
$stmt->execute(['id' => $id]);
$registro = $stmt->fetch();
if ($registro['estado'] !== 'caducada' || Demo::activa()) {
    throw new RuntimeException('La caducidad no elimina el entorno ni finaliza el registro.');
}
if ($contacto) {
    $stmt = $real->prepare('SELECT mensaje FROM contacto_mensajes WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetchColumn() !== 'Contacto que caduca') {
        throw new RuntimeException('Se pierde el contacto al caducar.');
    }
} elseif ($invalido) {
    if (http_response_code() !== 403 || $registro['sugerencias_fecha'] !== null || !isset($_SESSION['demo_salida_csrf'])) {
        throw new RuntimeException('La salida caducada acepta un CSRF inválido o pierde el contexto.');
    }
} elseif ($registro['sugerencias'] !== $_POST['sugerencias'] || !$registro['sugerencias_fecha']) {
    throw new RuntimeException('Se pierden las sugerencias al caducar.');
}
$completada = true;
echo "OK: caducidad durante salida " . ($contacto ? 'conserva contacto.' : ($invalido ? 'rechaza CSRF inválido.' : 'conserva sugerencias.')) . "\n";
