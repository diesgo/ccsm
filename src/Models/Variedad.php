<?php
// /src/Models/Variedad.php

class Variedad {
    /**
     * Obtiene todas las variedades registradas en el SQL
     */
    public static function all() {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT * FROM variedades ORDER BY id_variedad ASC")->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Busca una única variedad por su ID
     */
    public static function find($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM variedades WHERE id_variedad = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Registra una nueva variedad en la tabla
     */
    public static function save($nombre, $descripcion = null) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO variedades (variedad, descripcion_variedad) VALUES (:variedad, :descripcion)");
            return $stmt->execute([
                'variedad'    => trim($nombre),
                'descripcion' => !empty($descripcion) ? trim($descripcion) : null
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Modifica los datos de una variedad existente
     */
    public static function update($id, $nombre, $descripcion = null) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE variedades SET variedad = :variedad, descripcion_variedad = :descripcion WHERE id_variedad = :id");
            return $stmt->execute([
                'variedad'    => trim($nombre),
                'descripcion' => !empty($descripcion) ? trim($descripcion) : null,
                'id'          => $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>