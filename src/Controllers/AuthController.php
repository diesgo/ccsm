<?php
// /src/Controllers/AuthController.php

// Cargamos el controlador base y el modelo de usuario subiendo niveles limpios
require_once dirname(dirname(__DIR__)) . '/core/Controller.php';
require_once dirname(__DIR__) . '/Models/User.php';

class AuthController extends Controller
{

    /**
    * Muestra el formulario visual de inicio de sesión
    */
    public function showLogin()
    {
        // 🌟 CORRECCIÓN DE REBOTE: Si ya tiene sesión, lo mandamos a su pantalla correspondiente
        if (isset($_SESSION['user_id'])) {
            if (intval($_SESSION['perfil_id'] ?? 0) === 1) {
                header('Location: ' . URL_ROOT . '/');
            } else {
                header('Location: ' . URL_ROOT . '/dispensario');
            }
            exit;
        }

        $this->render('auth/login', [
            'titulo' => 'Iniciar Sesión - GreenPower',
            'error' => $_SESSION['demo_error'] ?? null
        ]);
        unset($_SESSION['demo_error']);
    }

    /**
    * Procesa el formulario de login cargando dinámicamente el perfil y los permisos RBAC reales
    */
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->showLogin();
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // 🌟 CUENTA DE PRIMER INICIO: solo vale mientras no exista ningún usuario en la base de datos
            if ($username === 'admin' && $password === 'admin123' && User::count() === 0) {
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_regenerate_id(true);
                }

                $_SESSION['user_id']   = 1;
                $_SESSION['username']  = 'admin';
                $_SESSION['nombre']    = 'ADMINISTRADOR SUPREMO';
                $_SESSION['perfil_id'] = 1;

                // Mapeo simétrico para el Bypass Maestro con tus columnas reales (Ver / Crear / Editar)
                $_SESSION['permisos'] = [
                    'ver_categorias' => 1, 'crear_categorias' => 1, 'edit_categorias' => 1,
                    'ver_personal' => 1, 'crear_personal' => 1, 'edit_personal' => 1,
                    'ver_roles' => 1, 'crear_roles' => 1, 'edit_roles' => 1,
                    'ver_proveedores' => 1, 'crear_proveedores' => 1, 'edit_proveedores' => 1,
                    'ver_socios' => 1, 'crear_socios' => 1, 'edit_socios' => 1,
                    'ver_productos' => 1, 'crear_productos' => 1, 'edit_productos' => 1,
                    'ver_variedades' => 1, 'crear_variedades' => 1, 'edit_variedades' => 1,
                    'ver_cuotas' => 1, 'crear_cuotas' => 1, 'edit_cuotas' => 1
                ];

                header('Location: ' . URL_ROOT . '/');
                exit;
            }

            // 🌟 VALIDACIÓN ORDINARIA POR BASE DE DATOS REAL
            $user = User::findByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_regenerate_id(true);
                }

                $_SESSION['user_id']   = intval($user['id_user']);
                $_SESSION['username']  = $user['username'];
                $_SESSION['nombre']    = $user['nombre'];
                $_SESSION['perfil_id'] = intval($user['perfil_id']);
                
                // 🌟 INYECCIÓN DE PERMISOS DESDE TU TABLA 'PERFILES' REAL
                $_SESSION['permisos'] = [];
                try {
                    $db = Database::getConnection();
                    // Consultamos la fila correspondiente al perfil del usuario de tu volcado
                    $sql = "SELECT * FROM perfiles WHERE id_perfil = :perfil_id";
                    $stmtP = $db->prepare($sql);
                    $stmtP->execute(['perfil_id' => $_SESSION['perfil_id']]);
                    $perfilData = $stmtP->fetch(PDO::FETCH_ASSOC);

                    if ($perfilData) {
                        // Recorremos las columnas y guardamos en la sesión aquellas que actúan como permisos
                        foreach ($perfilData as $columna => $valor) {
                            if ($columna !== 'id_perfil' && $columna !== 'perfil') {
                                $_SESSION['permisos'][$columna] = intval($valor);
                            }
                        }
                    }
                } catch (PDOException $e) {
                    if ($_SESSION['perfil_id'] === 1) {
                        $_SESSION['permisos']['ver_productos'] = 1;
                    }
                }

                // 🌟 ENRUTAMIENTO LOGÍSTICO COMPATIBLE CON TU ROL 5 (COMPRAS)
                if (intval($_SESSION['perfil_id']) === 1) {
                    // Administrador Supremo: al Panel Financiero
                    header('Location: ' . URL_ROOT . '/');
                } elseif (intval($_SESSION['perfil_id']) === 5) { 
                    // Perfil de Compras (lnavarro): directo al histórico de albaranes de almacén
                    header('Location: ' . URL_ROOT . '/compras');
                } else {
                    // Perfil de mostrador y otros rangos: al Dispensario TPV
                    header('Location: ' . URL_ROOT . '/dispensario');
                }
                exit;
            } else {
                $this->render('auth/login', [
                    'titulo' => 'Iniciar Sesión - GreenPower',
                    'error'  => 'Usuario o contraseña incorrectos.'
                ]);
            }
        }
    }

    /**
    * Cierra la sesión de forma limpia destruyendo cookies residuales
    */
    public function logout()
    {
        if (Demo::activa() || isset($_SESSION['demo_salida_id'])) {
            header('Location: ' . URL_ROOT . '/demo/salir');
            exit;
        }
        try {
            Demo::terminar();
        } catch (PDOException | RuntimeException $e) {
            error_log('Error al cerrar demo: ' . $e->getMessage());
            http_response_code(503);
            $this->render('auth/login', [
                'titulo' => 'Cerrar sesión - GreenPower',
                'error' => 'No se pudo eliminar el entorno demo. Contacta con el administrador o vuelve a intentar salir.'
            ]);
            return;
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        header('Location: ' . URL_ROOT . '/login');
        exit;
    }

    public function demo()
    {
        if (isset($_SESSION['user_id'])) {
            $this->showLogin();
            return;
        }
        if (isset($_SESSION['demo_salida_id'])) {
            header('Location: ' . URL_ROOT . '/demo/salir');
            return;
        }
        try {
            if (!is_string($_POST['csrf'] ?? null)
                || !isset($_SESSION['demo_entrada_csrf'])
                || !hash_equals($_SESSION['demo_entrada_csrf'], $_POST['csrf'])) {
                throw new InvalidArgumentException('La solicitud ha caducado. Vuelve a enviar el formulario de acceso a la demo.');
            }
            $visitante = RegistroDemo::validarVisitante($_POST);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            $this->render('auth/login', [
                'titulo' => 'Iniciar Sesión - GreenPower', 'error' => $e->getMessage(),
                'demoNombre' => is_string($_POST['demo_nombre'] ?? null) ? $_POST['demo_nombre'] : '',
                'demoEmail' => is_string($_POST['demo_email'] ?? null) ? $_POST['demo_email'] : ''
            ]);
            return;
        }
        try {
            Demo::iniciar($visitante);
            session_regenerate_id(true);
            header('Location: ' . URL_ROOT . '/');
            exit;
        } catch (PDOException | RuntimeException $e) {
            error_log('Error al iniciar demo: ' . $e->getMessage());
            http_response_code(503);
            $this->render('auth/login', [
                'titulo' => 'Iniciar Sesión - GreenPower',
                'error' => 'No se pudo preparar la demo aislada. Revisa los permisos de creación de bases de datos y el registro del servidor.'
            ]);
        }
    }
}
?>
