<?php
// /config/database.php
require_once __DIR__ . '/../core/Demo.php';
require_once __DIR__ . '/../core/AnaliticaDemo.php';

class Database {
    private static $instance = null;
    private static $baseActual = null;

    // Bloqueamos el constructor para evitar que se creen instancias con "new Database()"
    private function __construct() {}

    /**
     * Retorna la única instancia activa de la conexión PDO
     * @return PDO
     */
    public static function getConnection() {
        $base = Demo::activa() ? Demo::baseDeDatos() : DB_NAME;
        if (self::$instance === null || self::$baseActual !== $base) {
            try {
                // Estructuramos el DSN con los datos de config.php (el puerto es opcional; si no está definido, se usa el 3306 por defecto)
                $puerto = defined('DB_PORT') && DB_PORT ? DB_PORT : 3306;
                $dsn = "mysql:host=" . DB_HOST . ";port=" . $puerto . ";dbname=" . $base . ";charset=" . DB_CHARSET;
                
                // Opciones de configuración avanzadas de PDO
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en errores SQL
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve los datos como arrays asociativos
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desactiva la emulación; usa prepared statements reales
                ];

                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                self::$baseActual = $base;
                
            } catch (PDOException $e) {
                if (Demo::activa()) {
                    throw new RuntimeException('No se pudo conectar al entorno demo. No se utilizará la base de datos real.', 0, $e);
                }
                // En desarrollo muestra el error completo. En producción deberías guardar esto en un archivo log.
                die("Error crítico en la conexión a la base de datos: " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }

    public static function conectarServidor() {
        $puerto = defined('DB_PORT') && DB_PORT ? DB_PORT : 3306;
        return new PDO("mysql:host=" . DB_HOST . ";port=" . $puerto . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
}
?>