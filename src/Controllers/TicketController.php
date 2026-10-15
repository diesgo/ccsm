<?php
// /src/Controllers/TicketController.php

require_once ROOT_PATH . '/core/Controller.php';

class TicketController extends Controller {

    /**
     * Renderiza el resguardo térmico de mostrador purgando el búfer global de salida
     */
    public function imprimir() {
        // 🌟 CLAVE MAESTRA CONTRA EL MODO QUIRKS: Destruimos y limpiamos de forma absoluta 
        // cualquier salida previa del layout o del búfer para que no se mezcle con el TPV
        if (ob_get_length()) {
            ob_end_clean(); 
        }

        $idVenta = intval($_GET['id'] ?? 0);

        // Extraemos los datos relacionales idénticos de la base de datos MariaDB
        $db = Database::getConnection();
        $sql = "SELECT v.*, s.nombre, s.apellidos, s.card_id, s.saldo as saldo_actual, p.producto, p.pvp as precio_unitario, c.servicio_id
                FROM ventas v
                INNER JOIN socios s ON v.socio_id = s.id_socio
                INNER JOIN productos p ON v.producto_id = p.id_producto
                INNER JOIN categorias c ON p.categoria_id = c.id_categoria
                WHERE v.id_venta = :id LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $idVenta]);
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$venta) {
            header("HTTP/1.1 404 Not Found");
            die("Error: Operación no localizada en la auditoría de caja.");
        }

        $sufijo = (intval($venta['servicio_id'] ?? 2) === 1) ? 'g' : 'ud';
        $tarifaUnidad = (intval($venta['servicio_id'] ?? 2) === 1) ? '€/g' : '€/u';

        // Escupimos la cabecera limpia para indicarle a Firefox que procese HTML puro estándar
        header('Content-Type: text/html; charset=utf-8');
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ticket #<?php echo $venta['id_venta']; ?></title>
            <style>
                * { box-sizing: border-box; margin: 0; padding: 0; }
                body {
                    font-family: 'Courier New', Courier, monospace;
                    font-size: 12px;
                    color: #000;
                    width: 76mm; /* Ajuste óptimo para rollos de 80mm */
                    padding: 4mm;
                    background-color: #fff;
                }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .bold { font-weight: bold; }
                .linea-divisor { border-top: 1px dashed #000; margin: 3mm 0; }
                .header { margin-bottom: 4mm; }
                .header h1 { font-size: 15px; letter-spacing: 0.5px; margin-bottom: 1px; }
                .tabla-items { width: 100%; border-collapse: collapse; margin-top: 2mm; }
                .tabla-items td { padding: 1mm 0; vertical-align: top; }
                .totales { margin-top: 3mm; line-height: 1.5; }
                .pie { margin-top: 6mm; font-size: 10px; line-height: 1.3; }
                
                @media print {
                    body { width: 100%; padding: 0; }
                    @page { margin: 0; }
                }
            </style>
        </head>
        <body>

            <!-- Cabecera del Club -->
            <div class="header text-center">
                <h1>*** GREENPOWER ***</h1>
                <p>Club de Consumidores CCSM</p>
                <p>Software de Gestión Local</p>
            </div>

            <div class="linea-divisor"></div>

            <!-- Datos de la Transacción -->
            <div>
                <p><span class="bold">TICKET:</span> #<?php echo $venta['id_venta']; ?></p>
                <p><span class="bold">FECHA:</span> <?php echo date('d/m/Y H:i:s', strtotime($venta['date_add_venta'])); ?></p>
                <p><span class="bold">SOCIO:</span> <?php echo htmlspecialchars($venta['nombre'] . ' ' . $venta['apellidos'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><span class="bold">CARD ID:</span> <?php echo htmlspecialchars($venta['card_id'] ?? 'unknown', ENT_QUOTES, 'UTF-8'); ?></p>
            </div>

            <div class="linea-divisor"></div>

            <!-- Desglose del Artículo -->
            <table class="tabla-items">
                <thead>
                    <tr class="bold">
                        <td style="width: 55%;">ARTÍCULO</td>
                        <td class="text-center" style="width: 20%;">CANT.</td>
                        <td class="text-right" style="width: 25%;">TOTAL</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($venta['producto'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <small style="color:#555; font-size:10px;">(a <?php echo number_format($venta['precio_unitario'], 2, ',', '.'); ?><?php echo $tarifaUnidad; ?>)</small>
                        </td>
                        <td class="text-center"><?php echo number_format($venta['cantidad'], 2, ',', '.'); ?><?php echo $sufijo; ?></td>
                        <td class="text-right bold"><?php echo number_format($venta['total'], 2, ',', '.'); ?>€</td>
                    </tr>
                </tbody>
            </table>

            <div class="linea-divisor"></div>

            <!-- Estado de Cuentas del Monedero Prepago -->
            <div class="totales">
                <table style="width: 100%;">
                    <tr class="bold" style="font-size: 13px;">
                        <td>TOTAL COBRADO:</td>
                        <td class="text-right"><?php echo number_format($venta['total'], 2, ',', '.'); ?> €</td>
                    </tr>
                    <tr>
                        <td style="font-size: 10px; padding-top: 1mm;">SALDO DISPONIBLE:</td>
                        <td class="text-right" style="font-size: 10px; padding-top: 1mm;"><?php echo number_format($venta['saldo_actual'], 2, ',', '.'); ?> €</td>
                    </tr>
                </table>
            </div>

            <div class="linea-divisor"></div>

            <!-- Pie Normativo del Resguardo -->
            <div class="pie text-center">
                <p>Comprobante de consumo interno.</p>
                <p>Liquidado mediante saldo prepago.</p>
                <p>¡Gracias por tu colaboración!</p>
                <p class="bold" style="margin-top: 2mm;">*** GreenPower 100% Local ***</p>
            </div>

            <!-- DISPARADOR AUTOMÁTICO DE IMPRESIÓN -->
            <script>
                window.onload = function() {
                    window.print();
                }
            </script>
        </body>
        </html>
        <?php
        exit;
    }
}
?>