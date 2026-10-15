<?php
// /src/Models/Socio.php

class Socio
{
    /**
     * Obtiene todos los socios de la base de datos realizando un LEFT JOIN con la nueva tabla de cuotas
     * @return array Listado relacional de socios
     */
    public static function all($busqueda = ''){
        try {
            $db = Database::getConnection();

            // Consulta optimizada integrando la nueva tabla maestra de cuotas
            $sql = "SELECT s.*, g.genero, g.signo, p.pais, p.bandera, c.nombre_cuota, c.importe as cuota_importe 
                    FROM socios s
                    LEFT JOIN generos g ON s.genero_id = g.id_genero
                    LEFT JOIN paises p ON s.pais_id = p.id_pais
                    LEFT JOIN cuotas c ON s.cuota_id = c.id_cuota";
            $params = [];
            $busqueda = trim((string) $busqueda);
            if ($busqueda !== '') {
                $sql .= " WHERE CONCAT_WS(' ', s.nombre, s.apellidos) LIKE :q1
                          OR s.card_id LIKE :q2
                          OR s.id_socio = :q3";
                $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $busqueda) . '%';
                $params = ['q1' => $like, 'q2' => $like, 'q3' => ltrim($busqueda, '#')];
            }
            $sql .= " ORDER BY s.id_socio DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Obtiene todos los géneros disponibles en la base de datos
     */
    public static function getGeneros()
    {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT id_genero, genero, signo FROM generos")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Obtiene todos los países disponibles en la base de datos
     */
    public static function getPaises()
    {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT id_pais, pais, bandera FROM paises ORDER BY pais ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Inserta un nuevo socio de forma 100% segura inyectando la cuota_id y el estado de exención
     */
    public static function save($data)
    {
        try {
            $db = Database::getConnection();
            
            // Sincronización exacta con las nuevas columnas de tu MariaDB local
            $sql = "INSERT INTO socios (nombre, apellidos, genero_id, card_id, birth, pais_id, cuota_id, exento, consumo, saldo, activo) 
                    VALUES (:nombre, :apellidos, :genero_id, :card_id, :birth, :pais_id, :cuota_id, :exento, :consumo, :saldo, 1)";

            $stmt = $db->prepare($sql);
            return $stmt->execute([
                'nombre'    => trim($data['nombre']),
                'apellidos' => trim($data['apellidos']),
                'genero_id' => !empty($data['genero_id']) ? intval($data['genero_id']) : 1,
                'card_id'   => !empty($data['card_id']) ? trim($data['card_id']) : null,
                'birth'     => !empty($data['birth']) ? $data['birth'] : null,
                'pais_id'   => !empty($data['pais_id']) ? intval($data['pais_id']) : 1,
                'cuota_id'  => intval($data['cuota_id'] ?? 1),
                'exento'    => intval($data['exento'] ?? 0),
                'consumo'   => floatval($data['consumo'] ?? 0),
                'saldo'     => floatval($data['saldo'] ?? 0)
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Busca un socio de forma individual por su ID numérico
     */
    public static function find($id)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM socios WHERE id_socio = :id LIMIT 1");
            $stmt->execute(['id' => intval($id)]);
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza la ficha contable y relacional de un socio (Facultad de quienes tengan edit_socios)
     * Incluye la persistencia de las 3 fotografías y de los datos personales (nacimiento, género, país)
     */
    public static function updateContable($id, $nombre, $apellidos, $card_id, $activo, $cuota_id, $exento, $saldo, $consumo, $imagen_perfil = null, $idFront = null, $idBack = null, $birth = null, $genero_id = null, $pais_id = null){
        try {
            $db = Database::getConnection();

            $sql = "UPDATE socios SET 
                        nombre = :nombre, 
                        apellidos = :apellidos, 
                        card_id = :card_id, 
                        activo = :activo,
                        cuota_id = :cuota_id,
                        exento = :exento,
                        saldo = :saldo,
                        consumo = :consumo,
                        imagen_perfil = :imagen_perfil,
                        idFront = :idFront,
                        idBack = :idBack,
                        birth = :birth,
                        genero_id = :genero_id,
                        pais_id = :pais_id
                    WHERE id_socio = :id";

            $stmt = $db->prepare($sql);
            return $stmt->execute([
                'nombre'        => trim($nombre),
                'apellidos'     => trim($apellidos),
                'card_id'       => !empty($card_id) ? trim($card_id) : null,
                'activo'        => intval($activo),
                'cuota_id'      => intval($cuota_id),
                'exento'        => intval($exento),
                'saldo'         => floatval($saldo),
                'consumo'       => floatval($consumo),
                'imagen_perfil' => $imagen_perfil,
                'idFront'       => $idFront,
                'idBack'        => $idBack,
                'birth'         => !empty($birth) ? $birth : null,
                'genero_id'     => !empty($genero_id) ? intval($genero_id) : 1,
                'pais_id'       => !empty($pais_id) ? intval($pais_id) : 1,
                'id'            => intval($id)
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Método auxiliar dinámico para leer el listado de cuotas activas de MariaDB
     */
    public static function getCuotas()
    {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT * FROM cuotas WHERE activo = 1 ORDER BY id_cuota ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Cuenta el total de socios activos admitidos en el club
     * @return int
     */
    public static function countActivos()
    {
        try {
            $db = Database::getConnection();
            return (int) $db->query("SELECT COUNT(*) FROM socios WHERE activo = 1")->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
}
?>
