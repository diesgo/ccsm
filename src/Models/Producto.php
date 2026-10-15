<?php

//! /src/Models/Producto.php

class Producto
{
    //* Recupera todos los productos cruzando los datos con sus familias relacionales y tipos de servicio

    public static function all()
    {
        try {
            $db = Database::getConnection();

            // Incluye los datos de categoría e impuesto para mostrar el producto completo.
            $sql = "SELECT p.*, c.categoria, c.servicio_id, s.servicio, i.valor AS impuesto_porcentaje
                    FROM productos p
                    LEFT JOIN categorias c ON p.categoria_id = c.id_categoria
                    LEFT JOIN servicios s ON c.servicio_id = s.id_servicio
                    LEFT JOIN impuestos i ON p.impuesto_id = i.id_impuesto
                    ORDER BY p.id_producto DESC";

            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error crítico relacional en el modelo de productos: " . $e->getMessage());
        }
    }

    //* Obtiene todas las categorías activas

    public static function getCategorias()
    {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT id_categoria, categoria FROM categorias WHERE activo = 1 ORDER BY categoria ASC")->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    //  * Obtiene todas las variedades disponibles

    public static function getVariedades()
    {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT id_variedad, variedad FROM variedades ORDER BY variedad ASC")->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    //  * Obtiene todas las unidades de medida (servicios)

    public static function getServicios()
    {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT id_servicio, servicio FROM servicios ORDER BY servicio ASC")->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    //  * Extrae todos los tipos de IVA e impuestos de la base de datos real

    public static function getImpuestos()
    {
        try {
            $db = Database::getConnection();
            // Consulta directa a tu tabla real 'impuestos'
            return $db->query("SELECT id_impuesto, impuesto, valor FROM impuestos ORDER BY valor ASC")->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    //  * Precio orientativo = precio de compra + porcentaje de beneficio (null si no hay precio de compra)

    public static function precioOrientativo($precioCompra, $margen)
    {
        if ($precioCompra === null || $precioCompra === '' || !is_numeric($precioCompra)) {
            return null;
        }

        return round((float) $precioCompra * (1 + (float) $margen / 100), 2);
    }

    //  * Registra un nuevo producto de forma limpia en la base de datos sanitizada

    public static function save($nombre, $categoria_id, $variedad_id, $pvp, $impuesto_id, $dispensario, $visible, $imagen, $precio_compra = null)
    {
        try {
            $db = Database::getConnection();

            // Consulta SQL estructurada con las 9 columnas reales de tu MariaDB local
            $sql = "INSERT INTO productos (
                        producto, 
                        categoria_id, 
                        variedad_id, 
                        pvp, 
                        precio_compra, 
                        impuesto_id, 
                        dispensario, 
                        visible, 
                        imagen_producto
                    ) VALUES (
                        :producto, 
                        :categoria_id, 
                        :variedad_id, 
                        :pvp, 
                        :precio_compra, 
                        :impuesto_id, 
                        :dispensario, 
                        :visible, 
                        :imagen
                    )";

            $stmt = $db->prepare($sql);

            // Ejecutamos asociando de forma exacta los parámetros sanitizados
            return $stmt->execute([
                'producto'     => trim($nombre),
                'categoria_id' => intval($categoria_id),
                'variedad_id'  => $variedad_id ? intval($variedad_id) : null,
                'pvp'          => floatval($pvp),
                'precio_compra' => $precio_compra !== null ? floatval($precio_compra) : null,
                'impuesto_id'  => intval($impuesto_id),
                'dispensario'  => floatval($dispensario),
                'visible'      => intval($visible),
                'imagen'       => !empty($imagen) ? trim($imagen) : 'default.png'
            ]);
        } catch (PDOException $e) {
            // Si deseas inspeccionar fallos ocultos de MariaDB en caliente, puedes descomentar la línea inferior:
            // die("Error en el guardado SQL de Productos: " . $e->getMessage());
            return false;
        }
    }

    //  * Busca un único producto por su ID

    public static function find($id)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM productos WHERE id_producto = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    //  * Modifica los datos de un artículo existente en la base de datos sanitizada

    public static function update($id, $nombre, $categoria_id, $variedad_id, $pvp, $impuesto_id, $dispensario, $visible, $imagen, $precio_compra = null)
    {
        try {
            $db = Database::getConnection();

            $sql = "UPDATE productos SET 
                        producto = :producto, 
                        categoria_id = :categoria_id, 
                        variedad_id = :variedad_id, 
                        pvp = :pvp, 
                        precio_compra = :precio_compra, 
                        impuesto_id = :impuesto_id, 
                        dispensario = :dispensario, 
                        visible = :visible, 
                        imagen_producto = :imagen 
                    WHERE id_producto = :id";

            $stmt = $db->prepare($sql);
            return $stmt->execute([
                'producto'     => trim($nombre),
                'categoria_id' => intval($categoria_id),
                'variedad_id'  => $variedad_id ? intval($variedad_id) : null,
                'pvp'          => floatval($pvp),
                'precio_compra' => $precio_compra !== null ? floatval($precio_compra) : null,
                'impuesto_id'  => intval($impuesto_id),
                'dispensario'  => floatval($dispensario),
                'visible'      => intval($visible),
                'imagen'       => !empty($imagen) ? trim($imagen) : 'default.png',
                'id'           => intval($id)
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    //  * Calcula la suma total de gramos/unidades disponibles en el mostrador

    public static function countInventario()
    {
        try {
            $db = Database::getConnection();
            return (float) ($db->query("SELECT SUM(dispensario) FROM productos WHERE visible = 1")->fetchColumn() ?? 0);
        } catch (PDOException $e) {
            return 0.00;
        }
    }
}
?>
