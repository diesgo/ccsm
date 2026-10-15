<?php
require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Contacto.php';

class ContactoController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['contacto_csrf'])) {
            $_SESSION['contacto_csrf'] = bin2hex(random_bytes(24));
        }
        $enviado = $_SESSION['contacto_enviado'] ?? false;
        unset($_SESSION['contacto_enviado']);
        $this->render('contacto/index', ['titulo' => '¿Hablamos? - GreenPower', 'enviado' => $enviado]);
    }

    public function enviar()
    {
        $formulario = [];
        foreach (['nombre', 'email', 'tema', 'mensaje'] as $campo) {
            $formulario[$campo] = is_string($_POST[$campo] ?? null) ? $_POST[$campo] : '';
        }
        try {
            if (!isset($_SESSION['contacto_csrf']) || !is_string($_POST['csrf'] ?? null)
                || !hash_equals($_SESSION['contacto_csrf'], $_POST['csrf'])) {
                http_response_code(403);
                throw new InvalidArgumentException('La conversación ha caducado. Recarga la página e inténtalo de nuevo.');
            }
            if (!is_string($_POST['web'] ?? '') || ($_POST['web'] ?? '') !== '') {
                throw new InvalidArgumentException('No se pudo validar el mensaje. Vuelve a intentarlo desde el formulario.');
            }
            if (time() - ($_SESSION['contacto_ultimo_envio'] ?? 0) < 60) {
                http_response_code(429);
                throw new InvalidArgumentException('Tu último mensaje ya está en la bandeja. Espera un minuto antes de enviar otro.');
            }
            $datos = Contacto::validar($_POST);
            Contacto::guardar($datos);
            $_SESSION['contacto_ultimo_envio'] = time();
            $_SESSION['contacto_enviado'] = true;
            $_SESSION['contacto_csrf'] = bin2hex(random_bytes(24));
            header('Location: ' . URL_ROOT . '/contacto');
        } catch (InvalidArgumentException $e) {
            if (http_response_code() < 400) {
                http_response_code(400);
            }
            $this->render('contacto/index', ['titulo' => '¿Hablamos? - GreenPower', 'error' => $e->getMessage(), 'formulario' => $formulario]);
        } catch (PDOException $e) {
            error_log('Error al guardar contacto (SQLSTATE ' . $e->getCode() . ').');
            http_response_code(503);
            $this->render('contacto/index', [
                'titulo' => '¿Hablamos? - GreenPower', 'formulario' => $formulario,
                'error' => 'No hemos podido guardar tu mensaje. Tu texto sigue aquí para que puedas reintentarlo.'
            ]);
        }
    }

    private function autorizado()
    {
        if (Demo::activa() || intval($_SESSION['perfil_id'] ?? 0) !== 1 || !isset($_SESSION['user_id'])) {
            http_response_code(403);
            $this->render('contacto/bandeja', [
                'titulo' => 'Mensajes - GreenPower',
                'error' => 'Esta bandeja es privada. Solo pueden abrirla administradores fuera del modo demo.'
            ]);
            return false;
        }
        return true;
    }

    public function bandeja()
    {
        if (!$this->autorizado()) {
            return;
        }
        try {
            $pagina = filter_var($_GET['pagina'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if ($pagina === false) {
                throw new InvalidArgumentException('La página debe ser un número válido.');
            }
            $bandeja = Contacto::bandeja($pagina);
            $_SESSION['contacto_admin_csrf'] = $_SESSION['contacto_admin_csrf'] ?? bin2hex(random_bytes(24));
            $this->render('contacto/bandeja', ['titulo' => 'Mensajes - GreenPower', 'bandeja' => $bandeja]);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            $this->render('contacto/bandeja', ['titulo' => 'Mensajes - GreenPower', 'error' => $e->getMessage()]);
        } catch (PDOException $e) {
            error_log('Error al consultar contactos (SQLSTATE ' . $e->getCode() . ').');
            http_response_code(503);
            $this->render('contacto/bandeja', ['titulo' => 'Mensajes - GreenPower', 'error' => 'No se pudo cargar la bandeja. Revisa la migración y el registro del servidor.']);
        }
    }

    public function leido()
    {
        if (!$this->autorizado()) {
            return;
        }
        try {
            if (!isset($_SESSION['contacto_admin_csrf']) || !is_string($_POST['csrf'] ?? null)
                || !hash_equals($_SESSION['contacto_admin_csrf'], $_POST['csrf'])) {
                http_response_code(403);
                throw new InvalidArgumentException('Solicitud no válida. Vuelve a abrir la bandeja.');
            }
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if ($id === false) {
                throw new InvalidArgumentException('Selecciona un mensaje válido.');
            }
            Contacto::leido($id);
            header('Location: ' . URL_ROOT . '/contacto/bandeja');
        } catch (InvalidArgumentException $e) {
            if (http_response_code() < 400) {
                http_response_code(400);
            }
            $this->render('contacto/bandeja', ['titulo' => 'Mensajes - GreenPower', 'error' => $e->getMessage()]);
        } catch (PDOException $e) {
            error_log('Error al marcar contacto (SQLSTATE ' . $e->getCode() . ').');
            http_response_code(503);
            $this->render('contacto/bandeja', ['titulo' => 'Mensajes - GreenPower', 'error' => 'No se pudo marcar el mensaje como leído.']);
        }
    }
}
