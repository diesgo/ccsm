<?php
require_once ROOT_PATH . '/core/Controller.php';

class DemoController extends Controller
{
    public function actividad()
    {
        header('Content-Type: application/json; charset=utf-8');
        if (empty($_SESSION['demo']['registro_id'])
            || !is_string($_POST['csrf'] ?? null)
            || !isset($_SESSION['demo_actividad_csrf'])
            || !hash_equals($_SESSION['demo_actividad_csrf'], $_POST['csrf'])) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'La actividad requiere una sesión demo válida.']);
            return;
        }
        $ahora = time();
        $anterior = $_SESSION['demo_actividad_tiempo'] ?? $ahora;
        $segundos = max(0, min(35, $ahora - $anterior));
        try {
            RegistroDemo::actividad($_SESSION['demo']['registro_id'], $segundos);
            $_SESSION['demo_actividad_tiempo'] = $ahora;
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            error_log('No se pudo registrar actividad demo (SQLSTATE ' . $e->getCode() . ').');
            http_response_code(503);
            echo json_encode(['success' => false, 'message' => 'No se pudo registrar la actividad de la demo.']);
        }
    }

    public function salir()
    {
        if (!Demo::activa() && !isset($_SESSION['demo_salida_id'])) {
            header('Location: ' . URL_ROOT . '/login');
            return;
        }
        if (!isset($_SESSION['demo_salida_csrf'])) {
            $_SESSION['demo_salida_csrf'] = bin2hex(random_bytes(24));
        }
        $this->render('auth/demo-salir', [
            'titulo' => 'Finalizar demo - GreenPower',
            'aviso' => $_SESSION['demo_error'] ?? null
        ]);
    }

    public function finalizar()
    {
        if ((!Demo::activa() && !isset($_SESSION['demo_salida_id']))
            || !is_string($_POST['csrf'] ?? null)
            || !isset($_SESSION['demo_salida_csrf'])
            || !hash_equals($_SESSION['demo_salida_csrf'], $_POST['csrf'])) {
            http_response_code(403);
            echo 'Solicitud de salida no válida. Vuelve a abrir la pantalla de salida de la demo.';
            return;
        }
        if (!in_array($_POST['accion'] ?? null, ['enviar', 'omitir'], true)) {
            http_response_code(400);
            $this->render('auth/demo-salir', [
                'titulo' => 'Finalizar demo - GreenPower',
                'error' => 'Selecciona Enviar y salir o Salir sin enviar.'
            ]);
            return;
        }
        $texto = $_POST['accion'] === 'omitir' ? '' : ($_POST['sugerencias'] ?? '');
        try {
            $valoracion = RegistroDemo::valorar($_POST['accion'] === 'omitir' ? [] : $_POST);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            $this->render('auth/demo-salir', [
                'titulo' => 'Finalizar demo - GreenPower', 'error' => $e->getMessage(),
                'sugerencias' => is_string($texto) ? $texto : ''
            ]);
            return;
        }
        if (!is_string($texto) || mb_strlen(trim($texto)) > 4000) {
            http_response_code(400);
            $this->render('auth/demo-salir', [
                'titulo' => 'Finalizar demo - GreenPower',
                'error' => 'Las sugerencias deben tener como máximo 4000 caracteres.',
                'sugerencias' => is_string($texto) ? $texto : '', 'valoracion' => $valoracion
            ]);
            return;
        }
        try {
            $registroId = $_SESSION['demo_salida_id'] ?? ($_SESSION['demo']['registro_id'] ?? null);
            $csrf = $_SESSION['demo_salida_csrf'];
            Demo::terminar();
            $_SESSION = ['demo_salida_csrf' => $csrf];
            if ($registroId !== null) {
                $_SESSION['demo_salida_id'] = $registroId;
                RegistroDemo::sugerencias($registroId, $texto, $valoracion);
            }
        } catch (PDOException | RuntimeException $e) {
            error_log('Error al finalizar demo y registrar sugerencias: ' . $e->getMessage());
            http_response_code(503);
            $this->render('auth/demo-salir', [
                'titulo' => 'Finalizar demo - GreenPower',
                'error' => 'No se pudo finalizar la demo o registrar tu respuesta. Inténtalo de nuevo.',
                'sugerencias' => $texto, 'valoracion' => $valoracion
            ]);
            return;
        }
        $_SESSION = [];
        session_regenerate_id(true);
        header('Location: ' . URL_ROOT . '/login');
    }

    public function imagen()
    {
        $tipo = $_GET['tipo'] ?? '';
        $archivo = $_GET['archivo'] ?? '';
        if (!Demo::activa() || !is_string($tipo) || !in_array($tipo, ['socios', 'productos'], true)
            || !is_string($archivo) || !preg_match('/^[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)$/D', $archivo)) {
            http_response_code(404);
            echo 'Imagen demo no disponible.';
            return;
        }
        $ruta = Demo::carpetaImagenes($tipo) . $archivo;
        if (!is_file($ruta)) {
            http_response_code(404);
            echo 'Imagen demo no disponible.';
            return;
        }
        if (ob_get_length()) {
            ob_clean();
        }
        header('Content-Type: ' . (new finfo(FILEINFO_MIME_TYPE))->file($ruta));
        header('Cache-Control: private, no-store');
        header('X-Content-Type-Options: nosniff');
        readfile($ruta);
        exit;
    }
}
