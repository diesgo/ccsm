<?php
// /src/Models/Configuracion.php

class Configuracion {
    /**
     * Recupera todas las variables mapeándolas en un array clave-valor limpio
     */
    public static function all() {
        try {
            $db = Database::getConnection();
            $rows = $db->query("SELECT clave, valor FROM configuracion_sistema")->fetchAll(PDO::FETCH_ASSOC);
            
            $config = [];
            foreach ($rows as $r) {
                $config[$rows['clave'] ?? $r['clave']] = $r['valor'];
            }
            return $config;
        } catch (PDOException $e) { return []; }
    }

    /**
     * Porcentaje de beneficio configurado (30 por defecto si no existe o no es válido)
     */
    public static function margenBeneficio() {
        $valor = self::all()['margen_beneficio'] ?? null;
        return is_numeric($valor) && $valor >= 0 ? (float) $valor : 30.0;
    }

    /**
     * Guarda de forma masiva las opciones del formulario (crea la clave si no existe)
     */
    public static function guardarMasivo($data) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare(
                "INSERT INTO configuracion_sistema (clave, valor) VALUES (:clave, :valor)
                 ON DUPLICATE KEY UPDATE valor = VALUES(valor)"
            );
            
            foreach ($data as $clave => $valor) {
                $stmt->execute(['valor' => strval($valor), 'clave' => $clave]);
            }
            return true;
        } catch (PDOException $e) { return false; }
    }
}
?>