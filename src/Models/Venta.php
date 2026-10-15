<?php
// /src/Models/Venta.php

class Venta
{

    // ====================================================================
    // MÓDULO A: LOGÍSTICA DEL TERMINAL TPV Y EXTRACTOS DEL SOCIO
    // ====================================================================

    // LIBERADO: Extrae el historial integral completo para el Panel de Control y la base del TPV
    // @return array

    public static function obtenerVentasDelDia()
    {
        try {
            $db = Database::getConnection();

            // Eliminamos de forma definitiva la restricción 'WHERE DATE(...) = CURRENT_DATE'
            $sql = "SELECT v.id_venta, v.cantidad, v.total as importe_total, v.date_add_venta, 
                           s.nombre as socio_nombre, s.apellidos as socio_apellidos,
                           p.producto, c.servicio_id
                    FROM ventas v
                    INNER JOIN socios s ON v.socio_id = s.id_socio
                    INNER JOIN productos p ON v.producto_id = p.id_producto
                    INNER JOIN categorias c ON p.categoria_id = c.id_categoria
                    ORDER BY v.id_venta DESC"; // Las transacciones más frescas aparecen siempre primero

            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }



    // Obtiene todas las transacciones históricas acumuladas de un socio específico
    // @param int $idSocio
    // @return array

    public static function obtenerHistorialCompletoSocio($idSocio)
    {
        try {
            $db = Database::getConnection();

            // Unimos correctamente las categorías para recuperar el servicio_id en la pestaña
            $sql = "SELECT v.id_venta, v.cantidad, v.total as importe_total, v.date_add_venta, 
                           p.producto, c.servicio_id
                    FROM ventas v
                    INNER JOIN socios s ON v.socio_id = s.id_socio
                    INNER JOIN productos p ON v.producto_id = p.id_producto
                    INNER JOIN categorias c ON p.categoria_id = c.id_categoria
                    WHERE v.socio_id = :socio_id
                    ORDER BY v.id_venta DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute(['socio_id' => intval($idSocio)]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Procesa una dispensación interactiva registrándola en la tabla ventas
     */
    public static function procesar($idSocio, $idProducto, $cantidad, $total)
    {
        try {
            $db = Database::getConnection();
            $db->beginTransaction();

            $stmtProd = $db->prepare("SELECT pvp, dispensario FROM productos WHERE id_producto = :id LIMIT 1");
            $stmtProd->execute(['id' => $idProducto]);
            $prod = $stmtProd->fetch();

            if (!$prod || floatval($prod['dispensario']) < $cantidad) {
                $db->rollBack();
                return "Existencias insuficientes de este artículo en el mostrador.";
            }

            $stmtSocio = $db->prepare("SELECT saldo FROM socios WHERE id_socio = :id LIMIT 1");
            $stmtSocio->execute(['id' => $idSocio]);
            $socio = $stmtSocio->fetch();

            if (!$socio || floatval($socio['saldo']) < $total) {
                $db->rollBack();
                return "El socio no dispone de saldo suficiente en el monedero prepago.";
            }

            $saldoDespues = floatval($socio['saldo']) - $total;

            $updSocio = $db->prepare("UPDATE socios SET saldo = :nuevo WHERE id_socio = :id");
            $updSocio->execute(['nuevo' => $saldoDespues, 'id' => $idSocio]);

            $updProd = $db->prepare("UPDATE productos SET dispensario = dispensario - :cant WHERE id_producto = :id");
            $updProd->execute(['cant' => $cantidad, 'id' => $idProducto]);

            $sqlMov = "INSERT INTO ventas (socio_id, producto_id, cantidad, total, date_add_venta) 
                       VALUES (:socio_id, :producto_id, :cantidad, :total, CURRENT_TIMESTAMP)";

            $stmtMov = $db->prepare($sqlMov);
            $stmtMov->execute([
                'socio_id'    => $idSocio,
                'producto_id' => $idProducto,
                'cantidad'    => $cantidad,
                'total'       => $total
            ]);

            $db->commit();
            return true;
        } catch (PDOException $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            return "Fallo crítico en MariaDB: " . $e->getMessage();
        }
    }

    /**
     * Revierte y anula una transacción de mostrador reembolsando capital y stock
     */
    public static function anular($idVenta)
    {
        try {
            $db = Database::getConnection();
            $db->beginTransaction();

            $stmtVenta = $db->prepare("SELECT * FROM ventas WHERE id_venta = :id LIMIT 1");
            $stmtVenta->execute(['id' => $idVenta]);
            $venta = $stmtVenta->fetch();

            if (!$venta) {
                $db->rollBack();
                return "El ticket de venta solicitado no existe en la caja de hoy.";
            }

            $idSocio    = intval($venta['socio_id']);
            $idProducto = intval($venta['producto_id']);
            $cantidad   = floatval($venta['cantidad']);
            $total      = floatval($venta['total']);

            $updSocio = $db->prepare("UPDATE socios SET saldo = saldo + :total WHERE id_socio = :id_socio");
            $updSocio->execute(['total' => $total, 'id_socio' => $idSocio]);

            $updProd = $db->prepare("UPDATE productos SET dispensario = dispensario + :cant WHERE id_producto = :id_prod");
            $updProd->execute(['cant' => $cantidad, 'id_prod' => $idProducto]);

            $delVenta = $db->prepare("DELETE FROM ventas WHERE id_venta = :id");
            $delVenta->execute(['id' => $idVenta]);

            $db->commit();
            return true;
        } catch (PDOException $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            return "Error de base de datos en la reversión: " . $e->getMessage();
        }
    }


    // ====================================================================
    // MÓDULO B: ESTADÍSTICAS FINANCIERAS PARA EL DASHBOARD DE PORTADA
    // ====================================================================

    // Calcula la suma total de dinero depositado en los monederos de los socios
    // @return float

    public static function totalMonederos()
    {
        try {
            $db = Database::getConnection();
            return (float) ($db->query("SELECT SUM(saldo) FROM socios WHERE activo = 1")->fetchColumn() ?? 0);
        } catch (PDOException $e) {
            return 0.00;
        }
    }

    // Calcula la facturación total en euros debitada en el día de hoy
    // @return float

    public static function facturacionHoy()
    {
        try {
            $db = Database::getConnection();
            $sql = "SELECT SUM(total) FROM ventas WHERE DATE(date_add_venta) = CURRENT_DATE";
            return (float) ($db->query($sql)->fetchColumn() ?? 0);
        } catch (PDOException $e) {
            return 0.00;
        }
    }

    // Obtiene el histórico consolidado de dispensación para el gráfico Chart.js
    // @return array

    public static function balanceMensualHistorico()
    {
        try {
            $db = Database::getConnection();
            $sql = "SELECT DATE_FORMAT(date_add_venta, '%Y-%m') as mes, SUM(total) as total
                    FROM ventas 
                    WHERE date_add_venta >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
                    GROUP BY DATE_FORMAT(date_add_venta, '%Y-%m')
                    ORDER BY mes ASC";
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Extrae las ventas acumuladas agrupadas por familias para el gráfico de quesito
    // @return array

    public static function obtenerVentasPorCategoria()
    {
        try {
            $db = Database::getConnection();

            // Unimos ventas con productos y categorías según tu mapa de claves de MariaDB
            $sql = "SELECT c.categoria, SUM(v.total) as total_ventas
                    FROM ventas v
                    INNER JOIN productos p ON v.producto_id = p.id_producto
                    INNER JOIN categorias c ON p.categoria_id = c.id_categoria
                    GROUP BY c.id_categoria, c.categoria
                    ORDER BY total_ventas DESC";

            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>