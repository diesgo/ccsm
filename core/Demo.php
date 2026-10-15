<?php
require_once __DIR__ . '/../src/Models/RegistroDemo.php';

class Demo
{
    private const DURACION = 7200;
    private static $bloqueo = null;

    public static function habilitada()
    {
        return defined('DEMO_ENABLED') && DEMO_ENABLED === true;
    }

    public static function activa()
    {
        return isset($_SESSION['demo']);
    }

    private static function prefijo()
    {
        return 'ccsm_demo_' . substr(hash('sha256', ROOT_PATH), 0, 8) . '_';
    }

    private static function validarToken($token)
    {
        if (!is_string($token) || !preg_match('/^[a-f0-9]{24}$/D', $token)) {
            throw new RuntimeException('La sesión demo no es válida.');
        }
    }

    private static function directorio($token)
    {
        self::validarToken($token);
        return sys_get_temp_dir() . '/' . self::prefijo() . $token;
    }

    private static function nombreBase($token)
    {
        self::validarToken($token);
        return self::prefijo() . $token;
    }

    public static function validarSesion()
    {
        $demo = $_SESSION['demo'] ?? null;
        if (!is_array($demo) || !isset($demo['token'], $demo['expira'])) {
            throw new RuntimeException('La sesión demo no es válida.');
        }
        $dir = self::directorio($demo['token']);
        if (!is_file($dir . '/expira')) {
            throw new RuntimeException('El entorno demo ya no está disponible.');
        }
        if (self::$bloqueo === null) {
            self::$bloqueo = fopen($dir . '/bloqueo', 'c');
            if (self::$bloqueo === false || !flock(self::$bloqueo, LOCK_EX)) {
                throw new RuntimeException('No se pudo bloquear el entorno demo.');
            }
        }
        if ((int) $demo['expira'] <= time()) {
            throw new RuntimeException('La sesión demo ha caducado. Entra de nuevo para empezar desde cero.');
        }
    }

    public static function baseDeDatos()
    {
        self::validarSesion();
        return self::nombreBase($_SESSION['demo']['token']);
    }

    public static function iniciar($visitante = null)
    {
        if (!self::habilitada()) {
            throw new RuntimeException('El acceso demo está deshabilitado.');
        }
        self::limpiarCaducadas();
        $token = bin2hex(random_bytes(12));
        $dir = self::directorio($token);
        $nombreBase = self::nombreBase($token);
        $servidor = Database::conectarServidor();
        if (!mkdir($dir, 0700)) {
            throw new RuntimeException('No se pudo crear el directorio privado de la demo.');
        }
        $baseCreada = false;
        try {
            if (file_put_contents($dir . '/expira', (string) (time() + self::DURACION)) === false) {
                throw new RuntimeException('No se pudo registrar la caducidad de la demo.');
            }
            foreach (['socios', 'productos'] as $tipo) {
                if (!mkdir($dir . '/' . $tipo, 0700)) {
                    throw new RuntimeException('No se pudo crear la carpeta de imágenes demo.');
                }
                $defecto = ROOT_PATH . '/public/uploads/' . $tipo . '/default.png';
                if (is_file($defecto) && !copy($defecto, $dir . '/' . $tipo . '/default.png')) {
                    throw new RuntimeException('No se pudo preparar la imagen predeterminada demo.');
                }
            }
            $servidor->exec("CREATE DATABASE `$nombreBase` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
            $baseCreada = true;
            $servidor->exec("USE `$nombreBase`");
            foreach (['schema_produccion.sql', 'demo_datos.sql'] as $archivo) {
                $sql = file_get_contents(ROOT_PATH . '/' . $archivo);
                if ($sql === false) {
                    throw new RuntimeException('No se pudieron cargar los datos ficticios de la demo.');
                }
                $servidor->exec($sql);
            }
            $stmt = $servidor->prepare('INSERT INTO users (id_user, nombre, apellidos, email, username, password, perfil_id, activo) VALUES (1, :nombre, :apellidos, :email, :username, :password, 1, 1)');
            $stmt->execute([
                'nombre' => 'Usuario', 'apellidos' => 'Demo',
                'email' => 'demo@example.invalid', 'username' => 'demo',
                'password' => password_hash(bin2hex(random_bytes(24)), PASSWORD_DEFAULT)
            ]);
            $registroId = $visitante !== null
                ? RegistroDemo::iniciar($token, $visitante, (int) file_get_contents($dir . '/expira'))
                : null;
        } catch (PDOException | RuntimeException $e) {
            if ($baseCreada) {
                $servidor->exec("DROP DATABASE IF EXISTS `$nombreBase`");
            }
            self::eliminarArchivos($dir);
            throw $e;
        }
        $_SESSION = [
            'demo' => ['token' => $token, 'expira' => (int) file_get_contents($dir . '/expira'), 'registro_id' => $registroId],
            'user_id' => 1, 'username' => 'demo', 'nombre' => 'USUARIO DEMO',
            'perfil_id' => 1, 'permisos' => []
        ];
        $permisos = $servidor->query('SELECT * FROM perfiles WHERE id_perfil = 1')->fetch();
        foreach ($permisos as $columna => $valor) {
            if ($columna !== 'id_perfil' && $columna !== 'perfil') {
                $_SESSION['permisos'][$columna] = (int) $valor;
            }
        }
        self::validarSesion();
    }

    public static function terminar()
    {
        if (!self::activa()) {
            return;
        }
        $token = $_SESSION['demo']['token'];
        if (!empty($_SESSION['demo']['registro_id'])) {
            RegistroDemo::finalizar($token, (int) $_SESSION['demo']['expira'] <= time());
        }
        $nombreBase = self::nombreBase($token);
        Database::conectarServidor()->exec("DROP DATABASE IF EXISTS `$nombreBase`");
        if (is_resource(self::$bloqueo)) {
            flock(self::$bloqueo, LOCK_UN);
            fclose(self::$bloqueo);
        }
        self::$bloqueo = null;
        self::eliminarArchivos(self::directorio($token));
        unset($_SESSION['demo']);
    }

    public static function limpiarCaducadas()
    {
        $directorios = glob(sys_get_temp_dir() . '/' . self::prefijo() . '*', GLOB_ONLYDIR);
        if ($directorios === false) {
            throw new RuntimeException('No se pudieron consultar las sesiones demo caducadas.');
        }
        foreach ($directorios as $dir) {
            $token = substr(basename($dir), strlen(self::prefijo()));
            if (!preg_match('/^[a-f0-9]{24}$/D', $token) || !is_file($dir . '/expira')) {
                continue;
            }
            if ((int) file_get_contents($dir . '/expira') > time()) {
                continue;
            }
            $bloqueo = fopen($dir . '/bloqueo', 'c');
            if ($bloqueo === false) {
                throw new RuntimeException('No se pudo abrir una sesión demo para su limpieza.');
            }
            if (!flock($bloqueo, LOCK_EX | LOCK_NB)) {
                fclose($bloqueo);
                continue;
            }
            try {
                $nombreBase = self::nombreBase($token);
                RegistroDemo::finalizar($token, true);
                Database::conectarServidor()->exec("DROP DATABASE IF EXISTS `$nombreBase`");
                self::eliminarArchivos(self::directorio($token));
            } finally {
                flock($bloqueo, LOCK_UN);
                fclose($bloqueo);
            }
        }
    }

    private static function eliminarArchivos($dir)
    {
        foreach (['socios', 'productos'] as $tipo) {
            $carpeta = $dir . '/' . $tipo;
            if (!is_dir($carpeta)) {
                continue;
            }
            $archivos = scandir($carpeta);
            if ($archivos === false) {
                throw new RuntimeException('No se pudo leer la carpeta de imágenes demo.');
            }
            foreach ($archivos as $archivo) {
                if ($archivo !== '.' && $archivo !== '..' && !unlink($carpeta . '/' . $archivo)) {
                    throw new RuntimeException('No se pudo eliminar una imagen demo.');
                }
            }
            if (!rmdir($carpeta)) {
                throw new RuntimeException('No se pudo eliminar la carpeta de imágenes demo.');
            }
        }
        foreach (['expira', 'bloqueo'] as $archivo) {
            if (is_file($dir . '/' . $archivo) && !unlink($dir . '/' . $archivo)) {
                throw new RuntimeException('No se pudo eliminar el estado de la demo.');
            }
        }
        if (is_dir($dir) && !rmdir($dir)) {
            throw new RuntimeException('No se pudo eliminar el directorio de la demo.');
        }
    }

    public static function carpetaImagenes($tipo)
    {
        if (!in_array($tipo, ['socios', 'productos'], true)) {
            throw new InvalidArgumentException('Tipo de imágenes no válido.');
        }
        if (self::activa()) {
            self::validarSesion();
            return self::directorio($_SESSION['demo']['token']) . '/' . $tipo . '/';
        }
        return ROOT_PATH . '/public/uploads/' . $tipo . '/';
    }

    public static function urlImagen($tipo, $archivo)
    {
        if (!in_array($tipo, ['socios', 'productos'], true)) {
            throw new InvalidArgumentException('Tipo de imágenes no válido.');
        }
        if (self::activa()) {
            return URL_ROOT . '/demo/imagen?tipo=' . $tipo . '&archivo=' . rawurlencode($archivo);
        }
        return URL_ROOT . '/uploads/' . $tipo . '/' . rawurlencode($archivo);
    }
}
