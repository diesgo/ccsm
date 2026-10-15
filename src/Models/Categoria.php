<?php
// /src/Models/Categoria.php

class Categoria {
    public static function iconosDispensario() {
        return [
            'bi-flower3' => 'Flores',
            'bi-hexagon-fill' => 'Resinas',
            'bi-eyedropper' => 'Aceites',
            'bi-wind' => 'Vaporizadores',
            'bi-file-earmark' => 'Papel de liar',
            'bi-filter' => 'Filtros'
        ];
    }

    public static function iconosDisponibles() {
        return [
            '' => 'Sin icono',
            'bi-tag' => 'Etiqueta',
            'bi-basket' => 'Cesta',
            'bi-box-seam' => 'Caja',
            'bi-bag' => 'Bolsa',
            'bi-cup-straw' => 'Bebidas',
            'bi-cup-hot' => 'Café',
            'bi-egg-fried' => 'Comida',
            'bi-cookie' => 'Galleta',
            'bi-apple' => 'Fruta',
            'bi-leaf' => 'Hoja',
            'bi-flower1' => 'Flor',
            'bi-flower2' => 'Flor alternativa',
            'bi-droplet' => 'Gota',
            'bi-gem' => 'Gema',
            'bi-stars' => 'Estrellas',
            'bi-heart' => 'Corazón',
            'bi-gift' => 'Regalo',
            'bi-tools' => 'Herramientas',
            'bi-scissors' => 'Tijeras',
            'bi-book' => 'Libro',
            'bi-lightning' => 'Rayo',
            'bi-shop' => 'Tienda',
            'bi-grid' => 'Cuadrícula'
        ] + self::iconosDispensario();
    }

    /**
     * Obtiene todas las categorías uniendo el nombre de su unidad de medida
     */
    public static function all() {
        try {
            $db = Database::getConnection();
            $sql = "SELECT c.*, s.servicio 
                    FROM categorias c 
                    LEFT JOIN servicios s ON c.servicio_id = s.id_servicio 
                    ORDER BY c.id_categoria ASC";
            return $db->query($sql)->fetchAll();
        } catch (PDOException $e) { return []; }
    }

    public static function find($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM categorias WHERE id_categoria = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) { return false; }
    }

    public static function save($nombre, $activo = 1, $servicio_id = 2, $icono = '') {
        if (!array_key_exists($icono, self::iconosDisponibles())) {
            throw new InvalidArgumentException('El icono de categoría no es válido.');
        }
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO categorias (categoria, activo, servicio_id, icono) VALUES (:categoria, :activo, :servicio_id, :icono)");
            return $stmt->execute([
                'categoria'   => trim($nombre),
                'activo'      => $activo,
                'servicio_id' => $servicio_id,
                'icono'       => $icono
            ]);
        } catch (PDOException $e) {
            error_log('Error al crear categoría: ' . $e->getMessage());
            return false;
        }
    }

    public static function update($id, $nombre, $activo, $servicio_id, $icono = '') {
        if (!array_key_exists($icono, self::iconosDisponibles())) {
            throw new InvalidArgumentException('El icono de categoría no es válido.');
        }
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE categorias SET categoria = :categoria, activo = :activo, servicio_id = :servicio_id, icono = :icono WHERE id_categoria = :id");
            return $stmt->execute([
                'categoria'   => trim($nombre),
                'activo'      => $activo,
                'servicio_id' => $servicio_id,
                'icono'       => $icono,
                'id'          => $id
            ]);
        } catch (PDOException $e) {
            error_log('Error al actualizar categoría: ' . $e->getMessage());
            return false;
        }
    }
}
?>