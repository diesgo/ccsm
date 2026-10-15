<?php
// /src/Controllers/CompraController.php

require_once ROOT_PATH . '/core/Controller.php';

class CompraController extends Controller
{
    /**
     * Acceder al histórico de albaranes de compra del almacén
     */
    public function index()
    {
        try {
            $db = Database::getConnection();

            // Consultamos el histórico relacional de albaranes inyectando los nombres de proveedor y artículo
            $sql = "SELECT c.*, p.producto, pr.proveedor 
                    FROM compras c
                    INNER JOIN productos p ON c.producto_id = p.id_producto
                    INNER JOIN proveedores pr ON c.proveedor_id = pr.id_proveedor
                    ORDER BY c.date_compra DESC";

            $stmt = $db->query($sql);
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->render('compras/index', [
                'titulo'  => 'Histórico de Compras - GreenPower',
                'compras' => $compras
            ]);
        } catch (PDOException $e) {
            die("Error al acceder al registro de albaranes: " . $e->getMessage());
        }
    }

    /**
     * Despliega el formulario de registro de albaranes
     */
    public function crear()
    {
        try {
            $db = Database::getConnection();

            $stmtProv = $db->query("SELECT id_proveedor, proveedor FROM proveedores ORDER BY proveedor ASC");
            $proveedores = $stmtProv->fetchAll(PDO::FETCH_ASSOC);

            $sqlProductos = "SELECT p.id_producto, p.producto, c.servicio_id 
                             FROM productos p
                             INNER JOIN categorias c ON p.categoria_id = c.id_categoria
                             WHERE p.visible = 1 
                             ORDER BY p.producto ASC";

            $stmtProd = $db->query($sqlProductos);
            $productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

            $this->render('compras/crear', [
                'titulo'      => 'Registrar Compra - GreenPower',
                'proveedores' => $proveedores,
                'productos'   => $productos
            ]);
        } catch (PDOException $e) {
            die("Error de infraestructura al cargar el catálogo de compras: " . $e->getMessage());
        }
    }

    /**
     * Procesa el formulario, registra la compra, altera stock y engancha movimientos_stock
     */
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $proveedor_id = intval($_POST['proveedor_id'] ?? 0);
            $producto_id  = intval($_POST['producto_id'] ?? 0);
            $pcm          = floatval($_POST['pcm'] ?? 0);
            $unidades     = floatval($_POST['unidades'] ?? 0);
            $iva          = intval($_POST['iva'] ?? 0);
            $subtotal     = floatval($_POST['subtotal'] ?? 0);
            $total        = floatval($_POST['total'] ?? 0);
            $pvpFinal     = floatval($_POST['pvp_nuevo'] ?? 0);

            if ($proveedor_id <= 0 || $producto_id <= 0 || $unidades <= 0 || $pcm <= 0) {
                AnaliticaDemo::resultado(false);
                echo "<script>alert('Error: Datos obligatorios insuficientes.'); window.history.back();</script>";
                exit;
            }

            try {
                $db = Database::getConnection();
                $db->beginTransaction();

                // 🌟 PASO 0: CONSULTAR EL STOCK ACTUAL ANTES DE MODIFICARLO (Auditoría)
                $stmtAntes = $db->prepare("SELECT dispensario FROM productos WHERE id_producto = :id");
                $stmtAntes->execute(['id' => $producto_id]);
                $prodActual = $stmtAntes->fetch(PDO::FETCH_ASSOC);
                $stock_antes = floatval($prodActual['dispensario'] ?? 0);

                // Calcular balance aritmético del nuevo stock futuro
                $stock_despues = $stock_antes + $unidades;

                // 🌟 PASO 1: Insertar el asiento contable en la tabla 'compras'
                $sqlCompra = "INSERT INTO compras (proveedor_id, producto_id, pcm, unidades, iva, subtotal, total, date_compra) 
                              VALUES (:proveedor_id, :producto_id, :pcm, :unidades, :iva, :subtotal, :total, NOW())";
                $stmtCompra = $db->prepare($sqlCompra);
                $stmtCompra->execute([
                    'proveedor_id' => $proveedor_id,
                    'producto_id' => $producto_id,
                    'pcm' => $pcm,
                    'unidades' => $unidades,
                    'iva' => $iva,
                    'subtotal' => $subtotal,
                    'total' => $total
                ]);

                // 🌟 PASO 2: Incrementar el stock físico del dispensario
                $sqlStock = "UPDATE productos SET dispensario = :stock_despues WHERE id_producto = :id_producto";
                $stmtStock = $db->prepare($sqlStock);
                $stmtStock->execute(['stock_despues' => $stock_despues, 'id_producto' => $producto_id]);

                // 🌟 PASO 3: Actualizar el PVP del artículo si el operador lo especificó
                if ($pvpFinal > 0) {
                    $stmtPvp = $db->prepare("UPDATE productos SET pvp = :pvp WHERE id_producto = :id");
                    $stmtPvp->execute(['pvp' => $pvpFinal, 'id' => $producto_id]);
                }

                // 🌟 PASO 4: REGISTRO HISTÓRICO EN MOVIMIENTOS_STOCK CON DESTINO DISPENSARIO (ID 1)
                $sqlMov = "INSERT INTO movimientos_stock (proveedor_id, producto_id, stock_antes, unidades, retirada, destino_id, stock_despues, pcm, date_add_movimiento_stock) 
           VALUES (:proveedor_id, :producto_id, :stock_antes, :unidades, 0, 1, :stock_despues, :pcm, NOW())";

                $stmtMov = $db->prepare($sqlMov);
                $stmtMov->execute([
                    'proveedor_id' => $proveedor_id,
                    'producto_id'  => $producto_id,
                    'stock_antes'  => $stock_antes,
                    'unidades'     => $unidades,     // Sumamos las unidades/gramos recibidos
                    'stock_despues' => $stock_despues,  // Registramos el balance resultante
                    'pcm'          => $pcm
                ]);


                $db->commit();
                AnaliticaDemo::resultado(true);

                echo "<script>alert('¡Albarán y auditoría de movimiento procesados con éxito!'); window.location.href='" . URL_ROOT . "/compras';</script>";
                exit;
            } catch (PDOException $e) {
                AnaliticaDemo::resultado(false);
                if ($db->inTransaction()) $db->rollBack();
                die("Error transaccional en el almacén: " . $e->getMessage());
            }
        }
    }
}
?>
