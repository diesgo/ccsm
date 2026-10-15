<?php

class RegistroDemo
{
    private static function conexion()
    {
        $db = Database::conectarServidor();
        $base = str_replace('`', '``', DB_NAME);
        $db->exec("USE `$base`");
        return $db;
    }

    public static function validarVisitante($entrada)
    {
        $nombre = $entrada['demo_nombre'] ?? '';
        $email = $entrada['demo_email'] ?? '';
        if (!is_string($nombre) || !is_string($email)) {
            throw new InvalidArgumentException('Introduce un nombre y un email válidos.');
        }
        $nombre = trim($nombre);
        $email = strtolower(trim($email));
        if ($nombre === '' || mb_strlen($nombre) > 100) {
            throw new InvalidArgumentException('El nombre es obligatorio y debe tener como máximo 100 caracteres.');
        }
        if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Introduce una dirección de email válida.');
        }
        if (($entrada['demo_aviso'] ?? '') !== '1') {
            throw new InvalidArgumentException('Confirma que has leído el aviso sobre el registro de la demo.');
        }
        return ['nombre' => $nombre, 'email' => $email];
    }

    public static function iniciar($token, $visitante, $expira)
    {
        $db = self::conexion();
        $stmt = $db->prepare('INSERT INTO demo_usos (token_hash, nombre, email, expira) VALUES (:token, :nombre, :email, FROM_UNIXTIME(:expira))');
        $stmt->execute([
            'token' => hash('sha256', $token), 'nombre' => $visitante['nombre'],
            'email' => $visitante['email'], 'expira' => $expira
        ]);
        return (int) $db->lastInsertId();
    }

    public static function finalizar($token, $caducada = false)
    {
        $stmt = self::conexion()->prepare("UPDATE demo_usos SET fin = LEAST(NOW(), expira), estado = :estado WHERE token_hash = :token AND fin IS NULL");
        $stmt->execute(['token' => hash('sha256', $token), 'estado' => $caducada ? 'caducada' : 'finalizada']);
    }

    public static function valorar($entrada)
    {
        $facilidad = $entrada['facilidad'] ?? '';
        $instalaria = $entrada['instalaria'] ?? '';
        if (!is_string($facilidad) || !in_array($facilidad, ['', '1', '2', '3', '4', '5'], true)
            || !is_string($instalaria) || !in_array($instalaria, ['', 'si', 'quizas', 'no'], true)) {
            throw new InvalidArgumentException('Selecciona una valoración válida o deja las opciones sin marcar.');
        }
        return ['facilidad' => $facilidad === '' ? null : (int) $facilidad, 'instalaria' => $instalaria === '' ? null : $instalaria];
    }

    public static function evento($id, $seccion, $accion, $resultado)
    {
        $db = self::conexion();
        $stmt = $db->prepare('INSERT INTO demo_eventos (uso_id, seccion, accion, resultado)
            SELECT id, :seccion, :accion, :resultado FROM demo_usos WHERE id = :id AND fin IS NULL AND expira > NOW()');
        $stmt->execute(['id' => $id, 'seccion' => $seccion, 'accion' => $accion, 'resultado' => $resultado]);
        $stmt = $db->prepare('UPDATE demo_usos SET ultima_actividad = NOW() WHERE id = :id AND fin IS NULL AND expira > NOW()');
        $stmt->execute(['id' => $id]);
    }

    public static function actividad($id, $segundos)
    {
        $stmt = self::conexion()->prepare('UPDATE demo_usos SET ultima_actividad = NOW(),
            segundos_activos = segundos_activos + :segundos WHERE id = :id AND fin IS NULL AND expira > NOW()');
        $stmt->execute(['id' => $id, 'segundos' => $segundos]);
    }

    public static function sugerencias($id, $texto, $valoracion = ['facilidad' => null, 'instalaria' => null])
    {
        if (!is_string($texto) || mb_strlen(trim($texto)) > 4000) {
            throw new InvalidArgumentException('Las sugerencias deben tener como máximo 4000 caracteres.');
        }
        $stmt = self::conexion()->prepare('UPDATE demo_usos SET sugerencias = :texto, facilidad = :facilidad,
            instalaria = :instalaria, sugerencias_fecha = NOW() WHERE id = :id AND sugerencias_fecha IS NULL');
        $stmt->execute(['texto' => trim($texto) !== '' ? trim($texto) : null, 'id' => $id] + $valoracion);
    }

    public static function informe($pagina)
    {
        if (Demo::activa() || intval($_SESSION['perfil_id'] ?? 0) !== 1) {
            throw new RuntimeException('El seguimiento real de la demo solo está disponible para administradores fuera del modo demo.');
        }
        $db = self::conexion();
        $totales = $db->query("SELECT COUNT(*) AS usos, COUNT(DISTINCT email) AS visitantes,
            SUM(CASE WHEN sugerencias IS NOT NULL THEN 1 ELSE 0 END) AS sugerencias FROM demo_usos")->fetch();
        $totales['repetidores'] = (int) $db->query('SELECT COUNT(*) FROM (SELECT email FROM demo_usos GROUP BY email HAVING COUNT(*) > 1) repetidores')->fetchColumn();
        $paginas = max(1, (int) ceil($totales['usos'] / 50));
        $pagina = min($pagina, $paginas);
        $offset = ($pagina - 1) * 50;
        $filas = $db->query("SELECT u.*, u.expira <= NOW() AS caducada,
            GREATEST(0, TIMESTAMPDIFF(SECOND, u.inicio, COALESCE(u.fin, LEAST(NOW(), u.expira)))) AS duracion,
            visitas.usos AS usos_visitante,
            (SELECT COUNT(*) FROM demo_usos anterior WHERE anterior.email = u.email AND anterior.id <= u.id) AS numero_visita
            FROM demo_usos u
            INNER JOIN (SELECT email, COUNT(*) AS usos FROM demo_usos GROUP BY email) visitas ON visitas.email = u.email
            ORDER BY u.id DESC LIMIT 50 OFFSET $offset")->fetchAll();
        $resumen = $db->query("SELECT seccion, accion, COUNT(*) AS cantidad,
            SUM(resultado = 'error') AS errores, SUM(resultado = 'desconocido') AS desconocidos
            FROM demo_eventos GROUP BY seccion, accion ORDER BY cantidad DESC")->fetchAll();
        $totales['segundos_activos'] = (int) $db->query('SELECT COALESCE(SUM(segundos_activos), 0) FROM demo_usos')->fetchColumn();
        $totales['facilidad'] = $db->query('SELECT AVG(facilidad) FROM demo_usos')->fetchColumn();
        $eventos = [];
        if ($filas) {
            $ids = array_column($filas, 'id');
            $stmt = $db->prepare('SELECT uso_id, fecha, seccion, accion, resultado FROM demo_eventos
                WHERE uso_id IN (' . implode(',', array_fill(0, count($ids), '?')) . ') ORDER BY id');
            $stmt->execute($ids);
            foreach ($stmt->fetchAll() as $evento) {
                $eventos[$evento['uso_id']][] = $evento;
            }
        }
        return ['totales' => $totales, 'filas' => $filas, 'pagina' => $pagina, 'paginas' => $paginas, 'resumen' => $resumen, 'eventos' => $eventos];
    }
}
