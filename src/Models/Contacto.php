<?php

class Contacto
{
    public const TEMAS = [
        'hola' => 'Solo venía a saludar',
        'idea' => 'Tengo una idea',
        'ayuda' => 'Me vendría bien una mano',
        'instalar' => 'Quiero instalar GreenPower'
    ];

    private static function conexion()
    {
        $db = Database::conectarServidor();
        $base = str_replace('`', '``', DB_NAME);
        $db->exec("USE `$base`");
        return $db;
    }

    public static function validar($entrada)
    {
        $datos = [];
        foreach (['nombre', 'email', 'tema', 'mensaje'] as $campo) {
            if (!is_string($entrada[$campo] ?? null)) {
                throw new InvalidArgumentException('Revisa tu email, el tema y lo que quieres contarnos.');
            }
            $datos[$campo] = trim($entrada[$campo]);
        }
        $datos['email'] = strtolower($datos['email']);
        if (mb_strlen($datos['nombre']) > 100 || strlen($datos['email']) > 254
            || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Necesitamos un email válido para poder responderte. El nombre puede quedar vacío.');
        }
        if (!isset(self::TEMAS[$datos['tema']]) || $datos['mensaje'] === '' || mb_strlen($datos['mensaje']) > 4000) {
            throw new InvalidArgumentException('Elige un tema y cuéntanos algo en un máximo de 4000 caracteres.');
        }
        if (($entrada['aviso'] ?? '') !== '1') {
            throw new InvalidArgumentException('Confirma que has leído cómo se guarda tu mensaje.');
        }
        return $datos;
    }

    public static function guardar($datos)
    {
        $stmt = self::conexion()->prepare('INSERT INTO contacto_mensajes (nombre, email, tema, mensaje)
            VALUES (:nombre, :email, :tema, :mensaje)');
        $stmt->execute($datos);
    }

    public static function comprobarAdministrador()
    {
        if (Demo::activa() || intval($_SESSION['perfil_id'] ?? 0) !== 1 || !isset($_SESSION['user_id'])) {
            throw new RuntimeException('Los mensajes solo están disponibles para administradores fuera del modo demo.');
        }
    }

    public static function bandeja($pagina)
    {
        self::comprobarAdministrador();
        $db = self::conexion();
        $totales = $db->query('SELECT COUNT(*) AS total, COALESCE(SUM(leido = 0), 0) AS pendientes FROM contacto_mensajes')->fetch();
        $paginas = max(1, (int) ceil($totales['total'] / 30));
        $pagina = min($pagina, $paginas);
        $offset = ($pagina - 1) * 30;
        $filas = $db->query("SELECT * FROM contacto_mensajes ORDER BY id DESC LIMIT 30 OFFSET $offset")->fetchAll();
        return ['totales' => $totales, 'filas' => $filas, 'pagina' => $pagina, 'paginas' => $paginas];
    }

    public static function leido($id)
    {
        self::comprobarAdministrador();
        $stmt = self::conexion()->prepare('UPDATE contacto_mensajes SET leido = 1 WHERE id = :id');
        $stmt->execute(['id' => $id]);
        if ($stmt->rowCount() === 0) {
            $consulta = self::conexion()->prepare('SELECT id FROM contacto_mensajes WHERE id = :id');
            $consulta->execute(['id' => $id]);
            if (!$consulta->fetchColumn()) {
                throw new InvalidArgumentException('El mensaje no existe.');
            }
        }
    }
}
