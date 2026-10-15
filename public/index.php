<?php
// /public/index.php - LÍNEA 1 ABSOLUTA EN DESARROLLO LOCAL

// Algunos hostings envían install.php al router general aunque exista una
// regla específica en .htaccess. En ese caso, abrir el instalador desde aquí.
if (isset($_GET['url']) && trim((string) $_GET['url'], '/') === 'install.php') {
    require __DIR__ . '/install.php';
    exit;
}

// 🌟 APERTURA DE BÚFER OBLIGATORIA: Empaqueta el HTML para evitar pantallas en blanco en red
if (session_status() === PHP_SESSION_NONE) {
    ob_start(); 
}

// 1. Cargamos el motor de almacenamiento de sesiones privado (o tu bloque de sesiones actual)
$rutaSesionesPrivada = dirname(__DIR__) . '/sessions_temp';
if (!is_dir($rutaSesionesPrivada)) {
    mkdir($rutaSesionesPrivada, 0777, true);
}
session_save_path($rutaSesionesPrivada);

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

// ====================================================================
// (AQUÍ DEBAJO SE QUEDA TU REQUERIMIENTO DEL ENRUTADOR Y EL MAPA DE RUTAS)
// ====================================================================

// 2. Cargar los cimientos globales del sistema (define APP_ENV, DB_*, URL_ROOT, ROOT_PATH)
require_once dirname(__DIR__) . '/config/config.php';

// 3. Reportar errores según el entorno: en local se muestran en pantalla; en producción se ocultan
//    al visitante y se registran en /logs/php_errors.log (el instalador fija APP_ENV='production')
if (defined('APP_ENV') && APP_ENV === 'production') {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_PATH . '/logs/php_errors.log');
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}
error_reporting(E_ALL);

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/core/Router.php';

if (Demo::activa()) {
    try {
        Demo::validarSesion();
        Database::getConnection();
    } catch (RuntimeException $e) {
        error_log('Sesión demo no disponible: ' . $e->getMessage());
        $registroId = $_SESSION['demo']['registro_id'] ?? null;
        $csrfSalida = $_SESSION['demo_salida_csrf'] ?? null;
        $contactoContexto = array_intersect_key($_SESSION, array_flip(['contacto_csrf', 'contacto_ultimo_envio']));
        try {
            Demo::terminar();
        } catch (PDOException | RuntimeException $limpieza) {
            error_log('Error al limpiar demo: ' . $limpieza->getMessage());
            http_response_code(503);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'La demo no está disponible y no se pudo eliminar su entorno. Contacta con el administrador.']);
            exit;
        }
        $_SESSION = ['demo_error' => $e->getMessage()] + $contactoContexto;
        if ($registroId !== null) {
            $_SESSION['demo_salida_id'] = $registroId;
            if (is_string($csrfSalida)) {
                $_SESSION['demo_salida_csrf'] = $csrfSalida;
            }
        }
        session_regenerate_id(true);
        $urlDemo = trim($_GET['url'] ?? '', '/');
        $procesarSalida = ($registroId !== null && $urlDemo === 'demo/salir') || $urlDemo === 'contacto';
        if (!$procesarSalida && in_array($urlDemo, ['dispensario/socio', 'dispensario/recargar', 'dispensario/cobrar'], true)) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => $e->getMessage() . ' Vuelve a entrar en la demo.']);
        } elseif (!$procesarSalida) {
            header('Location: ' . URL_ROOT . ($registroId !== null ? '/demo/salir' : '/login'));
        }
        if (!$procesarSalida) {
            exit;
        }
    }
}

// 4. Instanciar el Enrutador Único
AnaliticaDemo::registrarPeticion($_GET['url'] ?? '', $_SERVER['REQUEST_METHOD']);
$router = new Router();

// 5. --- MAPA DE RUTAS REGISTRADAS DEL SISTEMA SANEADO ---

// Módulo de Inicio / Dashboard
$router->get('', 'HomeController@index');
$router->get('informes', 'InformeController@index');
$router->get('informes/demo', 'InformeController@demo');

// Módulo de Autenticación y Sesiones
$router->get('login', 'AuthController@showLogin');
$router->post('login', 'AuthController@login');
$router->get('logout', 'AuthController@logout');
$router->post('demo/entrar', 'AuthController@demo');
$router->get('demo/imagen', 'DemoController@imagen');
$router->get('demo/salir', 'DemoController@salir');
$router->post('demo/salir', 'DemoController@finalizar');
$router->post('demo/actividad', 'DemoController@actividad');
$router->get('contacto', 'ContactoController@index');
$router->post('contacto', 'ContactoController@enviar');
$router->get('contacto/bandeja', 'ContactoController@bandeja');
$router->post('contacto/leido', 'ContactoController@leido');

// Módulo de Socios
$router->get('socios', 'SocioController@index');
$router->get('socios/nuevo', 'SocioController@create');
$router->post('socios/guardar', 'SocioController@store');
$router->get('socios/editar', 'SocioController@edit');
$router->post('socios/actualizar', 'SocioController@update');

// Módulo de Productos
$router->get('productos', 'ProductoController@index');
$router->get('productos/nuevo', 'ProductoController@create');
$router->post('productos/guardar', 'ProductoController@store');
$router->get('productos/editar', 'ProductoController@edit');
$router->post('productos/actualizar', 'ProductoController@update');

// 🌟 REPARACIÓN ATÓMICA DE PERSONAL: Unificamos la sintaxis con '@' y mapeamos con tu UserController
// Módulo de Personal - ACEPTA TANTO USUARIOS COMO PERSONAL
$router->get('usuarios', 'UserController@index');
$router->get('personal', 'UserController@index'); // 🌟 ALIAS NUEVO: Levanta el listado si piden /personal

$router->get('usuarios/nuevo', 'UserController@create');
$router->get('personal/nuevo', 'UserController@create'); // 🌟 ALIAS NUEVO

$router->post('usuarios/guardar', 'UserController@store');
$router->post('personal/guardar', 'UserController@store'); // 🌟 ALIAS NUEVO

$router->get('usuarios/editar', 'UserController@edit');
$router->get('personal/editar', 'UserController@edit');

$router->post('usuarios/actualizar', 'UserController@update');
$router->post('personal/actualizar', 'UserController@update');

// Módulo de Roles y Permisos - COMPATIBLE CON AMBAS URLS
$router->get('perfiles', 'PerfilController@index');
$router->get('roles', 'PerfilController@index'); // 🌟 ALIAS DE RESCATE: Si piden /roles, abre el listado

$router->get('perfiles/editar', 'PerfilController@edit');
$router->get('roles/editar', 'PerfilController@edit'); // 🌟 ALIAS DE RESCATE: Si piden /roles/editar, abre la edición

$router->post('perfiles/actualizar', 'PerfilController@update');
$router->post('roles/actualizar', 'PerfilController@update'); // 🌟 ALIAS DE RESCATE

$router->post('perfiles/guardar', 'PerfilController@store');
$router->post('roles/guardar', 'PerfilController@store');

// Módulo del Dispensario TPV
$router->get('dispensario', 'DispensarioController@index');
$router->get('dispensario/socio', 'DispensarioController@obtenerSocio');
$router->post('dispensario/recargar', 'DispensarioController@recargarSaldo');
$router->post('dispensario/cobrar', 'DispensarioController@cobrar');
$router->get('dispensario/anular', 'DispensarioController@anularVenta');
$router->get('dispensario/factura', 'FacturaController@generarA4');
$router->get('dispensario/ticket', 'TicketController@imprimir');

// Módulo de Categorías
$router->get('categorias', 'CategoriaController@index');
$router->post('categorias/guardar', 'CategoriaController@store');
$router->get('categorias/editar', 'CategoriaController@edit');
$router->post('categorias/actualizar', 'CategoriaController@update');

// Módulo de Variedades
$router->get('variedades', 'VariedadController@index');
$router->post('variedades/guardar', 'VariedadController@store');
$router->get('variedades/editar', 'VariedadController@edit');
$router->post('variedades/actualizar', 'VariedadController@update');

// Módulo de Proveedores
$router->get('proveedores', 'ProveedorController@index');
$router->post('proveedores/guardar', 'ProveedorController@store');
$router->get('proveedores/editar', 'ProveedorController@edit');
$router->post('proveedores/actualizar', 'ProveedorController@update');

// Módulo Administrativo de Cuotas (CRUD) - EXCLUSIVO SUPERVISIÓN
$router->get('cuotas', 'CuotaController@index');
$router->get('cuotas/nuevo', 'CuotaController@create');
$router->post('cuotas/guardar', 'CuotaController@store');
$router->get('cuotas/editar', 'CuotaController@edit');
$router->post('cuotas/actualizar', 'CuotaController@update');


// Administración de comportamiento de caja
$router->get('configuracion', 'ConfiguracionController@index');
$router->post('configuracion/guardar', 'ConfiguracionController@guardar');

// 🌟 PURGADO DE ALMACÉN: Dejamos las 3 rutas únicas y definitivas de compras
$router->get('compras', 'CompraController@index');         
$router->get('compras/crear', 'CompraController@crear');   
$router->post('compras/guardar', 'CompraController@guardar'); 

// 🌟 CAPTURA ESTÁNDAR PARA ENTORNO LOCAL
$url = $_GET['url'] ?? '';
$url = trim($url, '/');

// Despachamos directamente a los controladores de mostrador
$router->dispatch($url);
// 7. Liberar el búfer de salida y enviar el HTML al navegador
ob_end_flush();
?>