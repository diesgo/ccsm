<?php
require_once dirname(__DIR__) . '/core/Instalador.php';

$instalador = new Instalador(dirname(__DIR__));
$requisitos = $instalador->requisitos();
$bloqueado = $instalador->bloqueado();
$error = null;
$instalado = false;
$url = '';
$formulario = [];
$esc = static function ($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); };

if (!$bloqueado && !in_array(false, $requisitos, true)) {
    if (session_status() === PHP_SESSION_NONE) {
        session_save_path(dirname(__DIR__) . '/sessions_temp');
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        session_start();
    }
    if (!isset($_SESSION['instalacion_csrf'])) {
        $_SESSION['instalacion_csrf'] = bin2hex(random_bytes(24));
    }
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        foreach ($_POST as $campo => $valor) {
            if (is_string($valor) && strpos($campo, 'clave') !== 0) {
                $formulario[$campo] = $valor;
            }
        }
        try {
            if (!is_string($_POST['csrf'] ?? null)
                || !hash_equals($_SESSION['instalacion_csrf'], $_POST['csrf'])) {
                throw new InvalidArgumentException('La solicitud ha caducado. Vuelve a enviar el formulario.');
            }
            $url = $instalador->instalar($_POST);
            unset($_SESSION['instalacion_csrf']);
            $instalado = true;
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            $error = $e->getMessage();
        } catch (PDOException $e) {
            error_log('Fallo SQL durante instalación CCSM (SQLSTATE ' . $e->getCode() . ').');
            http_response_code(503);
            $error = 'No se pudo completar la instalación. Revisa conexión, permisos y el estado de la base antes de reintentar: MariaDB no revierte automáticamente la creación de tablas.';
        } catch (RuntimeException $e) {
            error_log('Fallo de instalación CCSM: ' . $e->getMessage());
            http_response_code(503);
            $error = $e->getMessage();
        }
    }
} elseif ($bloqueado && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    http_response_code(403);
}

$ruta = dirname($_SERVER['SCRIPT_NAME'] ?? '/install.php');
$urlDetectada = $ruta === '/' || $ruta === '.' ? '' : preg_replace('~/public$~', '', $ruta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instalación de GreenPower CCSM</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f8f9fa; color: #212529; padding: 1rem; }
        main { max-width: 760px; margin: auto; background: white; padding: 2rem; border: 1px solid #dee2e6; border-radius: .5rem; }
        label { display: block; margin-top: 1rem; }
        input { box-sizing: border-box; width: 100%; padding: .6rem; margin-top: .3rem; }
        input[type=checkbox] { width: auto; }
        fieldset { margin: 1.5rem 0; border: 1px solid #dee2e6; }
        button { padding: .8rem; background: #198754; color: white; border: 0; border-radius: .3rem; }
        .error { padding: 1rem; background: #f8d7da; }
    </style>
</head>
<body><main>
    <h1>Instalación de GreenPower CCSM</h1>
    <?php if ($instalado): ?>
        <h2>Instalación completada</h2>
        <p>Se han creado las tablas y el administrador. La demo queda deshabilitada por defecto.</p>
        <p>Retira el instalador del servidor y conserva el candado de instalación.</p>
        <a href="<?php echo $esc($url . '/login'); ?>">Iniciar sesión</a>
    <?php elseif ($bloqueado): ?>
        <h2>Instalación protegida</h2>
        <p>Ya existe una configuración o un candado de instalación. No se modificará la aplicación ni la base de datos.</p>
        <p>Para una instalación nueva usa una copia independiente, sin la configuración local, y una base vacía.</p>
    <?php else: ?>
        <p>Instala únicamente en una base vacía. Este asistente no elimina tablas ni datos existentes.</p>
        <ul>
            <?php foreach ($requisitos as $nombre => $cumple): ?>
                <li><?php echo $esc($nombre); ?>: <strong><?php echo $cumple ? 'OK' : 'Falta'; ?></strong></li>
            <?php endforeach; ?>
        </ul>
        <?php if ($error !== null): ?><p class="error" role="alert"><?php echo $esc($error); ?></p><?php endif; ?>
        <?php if (!in_array(false, $requisitos, true)): ?>
            <form method="POST">
                <input type="hidden" name="csrf" value="<?php echo $esc($_SESSION['instalacion_csrf']); ?>">
                <fieldset><legend>Base de datos</legend>
                    <?php foreach (['host' => ['Host', '127.0.0.1'], 'puerto' => ['Puerto', '3306'], 'base' => ['Nombre de base vacía', ''], 'usuario_db' => ['Usuario de base de datos', '']] as $campo => [$etiqueta, $defecto]): ?>
                        <label><?php echo $etiqueta; ?><input name="<?php echo $campo; ?>" value="<?php echo $esc($formulario[$campo] ?? $defecto); ?>" required></label>
                    <?php endforeach; ?>
                    <label>Contraseña de base de datos<input type="password" name="clave_db" autocomplete="new-password"></label>
                </fieldset>
                <fieldset><legend>Aplicación y administrador</legend>
                    <label>URL pública o ruta (vacía para la raíz)<input name="url" value="<?php echo $esc($formulario['url'] ?? $urlDetectada); ?>" placeholder="https://www.dominio.es/ccsm"></label>
                    <?php foreach (['nombre' => ['Nombre', 'text', 40], 'email' => ['Email', 'email', 100], 'usuario_admin' => ['Usuario', 'text', 40]] as $campo => [$etiqueta, $tipo, $limite]): ?>
                        <label><?php echo $etiqueta; ?><input type="<?php echo $tipo; ?>" name="<?php echo $campo; ?>" maxlength="<?php echo $limite; ?>" value="<?php echo $esc($formulario[$campo] ?? ''); ?>" required></label>
                    <?php endforeach; ?>
                    <label>Contraseña (12-72 bytes)<input type="password" name="clave_admin" autocomplete="new-password" required></label>
                    <label>Repetir contraseña<input type="password" name="clave_confirmacion" autocomplete="new-password" required></label>
                </fieldset>
                <p>Revisa los datos antes de continuar. El asistente creará tablas, una cuenta administradora y la configuración de producción, sin datos de negocio de prueba.</p>
                <label><input type="checkbox" name="confirmar" value="1" required> Confirmo que esta es una instalación nueva en una base vacía.</label>
                <p><button type="submit">Instalar CCSM</button></p>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</main></body>
</html>
