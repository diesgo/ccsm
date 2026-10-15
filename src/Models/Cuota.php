<?php
// /src/Models/Cuota.php

class Cuota
{
    /**
     * Recupera todas las cuotas de la base de datos
     */
    public static function all()
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM cuotas ORDER BY id_cuota ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Busca una cuota específica por su ID
     */
    public static function find($id)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM cuotas WHERE id_cuota = :id LIMIT 1");
            $stmt->execute(['id' => intval($id)]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Guarda una nueva cuota en MariaDB
     */
    public static function save($nombre, $importe, $activo)
    {
        try {
            $db = Database::getConnection();
            $sql = "INSERT INTO cuotas (nombre_cuota, importe, activo) VALUES (:nombre, :importe, :activo)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                'nombre'  => trim($nombre),
                'importe' => floatval($importe),
                'activo'  => intval($activo)
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza los datos de una cuota existente
     */
    public static function update($id, $nombre, $importe, $activo)
    {
        try {
            $db = Database::getConnection();
            $sql = "UPDATE cuotas SET nombre_cuota = :nombre, importe = :importe, activo = :activo WHERE id_cuota = :id";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                'nombre'  => trim($nombre),
                'importe' => floatval($importe),
                'activo'  => intval($activo),
                'id'      => intval($id)
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>