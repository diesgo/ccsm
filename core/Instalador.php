<?php

class Instalador
{
    private $raiz;

    public function __construct($raiz)
    {
        $this->raiz = rtrim($raiz, '/');
    }

    public function bloqueado()
    {
        return is_file($this->raiz . '/config/installed.lock')
            || is_file($this->raiz . '/config/config.php');
    }

    public function requisitos()
    {
        return [
            'PHP 7.4 o superior' => PHP_VERSION_ID >= 70400,
            'PDO MySQL' => extension_loaded('pdo_mysql'),
            'Mbstring' => extension_loaded('mbstring'),
            'Fileinfo' => extension_loaded('fileinfo'),
            'Esquema de producción disponible' => is_readable($this->raiz . '/schema_produccion.sql'),
            'Carpeta config con permiso de escritura' => is_dir($this->raiz . '/config') && is_writable($this->raiz . '/config'),
            'Carpeta logs con permiso de escritura' => is_dir($this->raiz . '/logs') && is_writable($this->raiz . '/logs'),
            'Carpeta sessions_temp con permiso de escritura' => is_dir($this->raiz . '/sessions_temp') && is_writable($this->raiz . '/sessions_temp'),
            'Fotos de socios con permiso de escritura' => is_dir($this->raiz . '/public/uploads/socios') && is_writable($this->raiz . '/public/uploads/socios'),
            'Fotos de productos con permiso de escritura' => is_dir($this->raiz . '/public/uploads/productos') && is_writable($this->raiz . '/public/uploads/productos')
        ];
    }

    public static function validar($entrada)
    {
        $datos = [];
        foreach (['host', 'puerto', 'base', 'usuario_db', 'clave_db', 'url', 'nombre', 'email', 'usuario_admin', 'clave_admin', 'clave_confirmacion'] as $campo) {
            if (!is_string($entrada[$campo] ?? null)) {
                throw new InvalidArgumentException('Completa todos los campos del formulario.');
            }
            $datos[$campo] = strpos($campo, 'clave') === 0 ? $entrada[$campo] : trim($entrada[$campo]);
        }
        if (!preg_match('/^[a-zA-Z0-9._:-]+$/D', $datos['host'])
            || !preg_match('/^[a-zA-Z0-9_]{1,64}$/D', $datos['base'])
            || $datos['usuario_db'] === '') {
            throw new InvalidArgumentException('Revisa el host, el nombre de base de datos y su usuario.');
        }
        $puerto = filter_var($datos['puerto'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 65535]]);
        if ($puerto === false) {
            throw new InvalidArgumentException('El puerto debe estar entre 1 y 65535.');
        }
        $datos['puerto'] = $puerto;
        $datos['url'] = rtrim($datos['url'], '/');
        if ($datos['url'] !== '' && !preg_match('~^/[a-zA-Z0-9/_-]*$~D', $datos['url'])) {
            $url = parse_url($datos['url']);
            if (!filter_var($datos['url'], FILTER_VALIDATE_URL) || !$url
                || !in_array($url['scheme'] ?? '', ['http', 'https'], true)
                || isset($url['user']) || isset($url['pass']) || isset($url['query']) || isset($url['fragment'])) {
                throw new InvalidArgumentException('La URL debe ser HTTP/HTTPS o una ruta como /ccsm, sin parámetros.');
            }
        }
        if ($datos['nombre'] === '' || mb_strlen($datos['nombre']) > 40
            || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL) || strlen($datos['email']) > 100
            || !preg_match('/^[a-zA-Z0-9._-]{1,40}$/D', $datos['usuario_admin'])) {
            throw new InvalidArgumentException('Revisa el administrador: nombre (40 caracteres), email (100) y usuario (40, letras, números, punto, guion o guion bajo).');
        }
        if (strlen($datos['clave_admin']) < 12 || strlen($datos['clave_admin']) > 72
            || strpos($datos['clave_admin'], "\0") !== false
            || $datos['clave_admin'] !== $datos['clave_confirmacion']) {
            throw new InvalidArgumentException('La contraseña debe tener entre 12 y 72 bytes y coincidir en ambos campos.');
        }
        if (($entrada['confirmar'] ?? '') !== '1') {
            throw new InvalidArgumentException('Confirma que vas a instalar en una base vacía.');
        }
        return $datos;
    }

    private static function conectar($datos)
    {
        return new PDO('mysql:host=' . $datos['host'] . ';port=' . $datos['puerto'] . ';charset=utf8mb4',
            $datos['usuario_db'], $datos['clave_db'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
    }

    public static function configuracion($datos)
    {
        $contenido = "<?php\n";
        foreach ([
            'APP_ENV' => 'production', 'DEMO_ENABLED' => false,
            'DB_HOST' => $datos['host'], 'DB_PORT' => $datos['puerto'],
            'DB_USER' => $datos['usuario_db'], 'DB_PASS' => $datos['clave_db'],
            'DB_NAME' => $datos['base'], 'DB_CHARSET' => 'utf8mb4', 'URL_ROOT' => $datos['url']
        ] as $clave => $valor) {
            $contenido .= "define('$clave', " . var_export($valor, true) . ");\n";
        }
        return $contenido . "define('ROOT_PATH', dirname(__DIR__));\n";
    }

    public function instalar($entrada)
    {
        $datos = self::validar($entrada);
        if (in_array(false, $this->requisitos(), true)) {
            throw new RuntimeException('No se cumplen todos los requisitos del servidor.');
        }
        $bloqueo = fopen($this->raiz . '/config/instalacion.lock', 'c');
        if ($bloqueo === false) {
            throw new RuntimeException('No se pudo abrir el candado de instalación.');
        }
        $temporal = null;
        try {
            if (!flock($bloqueo, LOCK_EX | LOCK_NB)) {
                throw new RuntimeException('Ya hay otra instalación en curso.');
            }
            if ($this->bloqueado()) {
                throw new RuntimeException('Ya existe una configuración o un candado. No se modificará la instalación existente.');
            }
            $db = self::conectar($datos);
            $consulta = $db->prepare('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = :base');
            $consulta->execute(['base' => $datos['base']]);
            if ((int) $consulta->fetchColumn() > 0) {
                throw new RuntimeException('La base contiene tablas. El instalador solo admite bases vacías y no borra datos.');
            }
            $temporal = tempnam($this->raiz . '/config', '.instalacion-');
            if ($temporal === false) {
                $temporal = null;
                throw new RuntimeException('No se pudo preparar el archivo de configuración.');
            }
            $contenido = self::configuracion($datos);
            if (file_put_contents($temporal, $contenido) !== strlen($contenido)) {
                throw new RuntimeException('No se pudo escribir la configuración.');
            }
            $esquema = file_get_contents($this->raiz . '/schema_produccion.sql');
            if ($esquema === false) {
                throw new RuntimeException('No se pudo leer el esquema de producción.');
            }
            $base = $datos['base'];
            $consultaBase = $db->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = :base');
            $consultaBase->execute(['base' => $base]);
            if ((int) $consultaBase->fetchColumn() === 0) {
                $db->exec("CREATE DATABASE `$base` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
            }
            $db->exec("USE `$base`");
            $db->exec($esquema);
            $stmt = $db->prepare('INSERT INTO users (nombre, apellidos, email, username, password, perfil_id, activo)
                VALUES (:nombre, :apellidos, :email, :usuario, :clave, 1, 1)');
            $stmt->execute([
                'nombre' => $datos['nombre'], 'apellidos' => '',
                'email' => $datos['email'], 'usuario' => $datos['usuario_admin'],
                'clave' => password_hash($datos['clave_admin'], PASSWORD_DEFAULT)
            ]);
            if (!rename($temporal, $this->raiz . '/config/config.php')) {
                throw new RuntimeException('Se crearon las tablas, pero no se pudo publicar la configuración. No repitas la instalación sin revisar la base.');
            }
            $temporal = null;
            if (file_put_contents($this->raiz . '/config/installed.lock', date('c') . "\n", LOCK_EX) === false) {
                throw new RuntimeException('La instalación se configuró, pero no se pudo crear installed.lock. El archivo config.php impide repetirla.');
            }
        } finally {
            if ($temporal !== null && is_file($temporal) && !unlink($temporal)) {
                error_log('No se pudo eliminar el archivo temporal de configuración del instalador.');
            }
            flock($bloqueo, LOCK_UN);
            fclose($bloqueo);
        }
        return $datos['url'];
    }
}
