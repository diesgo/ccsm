<?php
// /src/Models/Proveedor.php

class Proveedor {
    /**
     * Obtiene todos los proveedores registrados en el SQL
     */
    public static function all() {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT * FROM proveedores ORDER BY id_proveedor ASC")->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Busca un único proveedor por su ID
     */
    public static function find($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM proveedores WHERE id_proveedor = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Registra un nuevo proveedor logístico
     */
    public static function save($nombre, $descripcion = null) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO proveedores (proveedor, descripcion_proveedor) VALUES (:proveedor, :descripcion)");
            return $stmt->execute([
                'proveedor'   => trim($nombre),
                'descripcion' => !empty($descripcion) ? trim($descripcion) : null
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Modifica un proveedor existente
     */
    public static function update($id, $nombre, $descripcion = null) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE proveedores SET proveedor = :proveedor, descripcion_proveedor = :descripcion WHERE id_proveedor = :id");
            return $stmt->execute([
                'proveedor'   => trim($nombre),
                'descripcion' => !empty($descripcion) ? trim($descripcion) : null,
                'id'          => $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>