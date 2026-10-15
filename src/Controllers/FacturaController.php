<?php
// /src/Controllers/FacturaController.php

require_once ROOT_PATH . '/core/Controller.php';

// 🌟 RUTA CORREGIDA: Apuntamos al nuevo directorio unificado de la librería
require_once ROOT_PATH . '/core/fpdf/fpdf.php'; 

require_once ROOT_PATH . '/src/Models/Venta.php';
require_once ROOT_PATH . '/src/Models/Socio.php';
require_once ROOT_PATH . '/src/Models/Configuracion.php';

class FacturaController extends Controller {
   // ... El resto de la lógica interna de tu FPDF e inyección de datos de MariaDB queda exactamente igual abajo ...


    /**
     * Genera la previsualización del PDF A4 utilizando estrictamente las fuentes internas del binario
     */
    public function generarA4() {
        if (ob_get_length()) ob_clean(); 

        $idVenta = intval($_GET['id'] ?? 0);
        
        $db = Database::getConnection();
        $sql = "SELECT v.*, s.nombre, s.apellidos, s.card_id, p.producto, p.pvp as precio_unitario, c.servicio_id
                FROM ventas v
                INNER JOIN socios s ON v.socio_id = s.id_socio
                INNER JOIN productos p ON v.producto_id = p.id_producto
                INNER JOIN categorias c ON p.categoria_id = c.id_categoria
                WHERE v.id_venta = :id LIMIT 1";
                
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $idVenta]);
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$venta) {
            die("Error operativo: El registro de venta especificado no existe.");
        }

        // ====================================================================
        // CONSTRUCCIÓN DE LA PLANTILLA CON FUENTES NATIVAS EN MAYÚSCULAS
        // ====================================================================
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 15);

        // Cabecera Corporativa: Verde Forestal de GreenPower
        $pdf->SetFillColor(27, 67, 50); 
        $pdf->Rect(0, 0, 210, 40, 'F');
        
        // 🌟 CLAVE MAESTRA: Usamos 'Helvetica' (Primera letra en Mayúscula) sin estilos adicionales
        // Esto le dice a FPDF que use el recurso grabado en su código fuente sin buscar archivos en disco
        $pdf->SetFont('Helvetica', '', 22); 
        $pdf->SetTextColor(255, 193, 7); 
        $pdf->SetY(12);
        $pdf->Cell(0, 10, 'GREENPOWER CCSM', 0, 1, 'L');
        
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(240, 240, 240);
        $pdf->Cell(0, 5, 'Club de Consumidores - Software de Gestion Interna Local', 0, 1, 'L');

        // Cuadrante de Datos de la Factura Simplificada
        $pdf->SetY(48);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(0, 6, 'FACTURA SIMPLIFICADA / COMPROBANTE', 0, 1, 'L');
        $pdf->SetDrawColor(255, 193, 7);
        $pdf->Line(15, $pdf->GetY() + 1, 195, $pdf->GetY() + 1);
        $pdf->Ln(4);

        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(90, 6, 'Nro. Operacion: #' . $venta['id_venta'], 0, 0, 'L');
        $pdf->Cell(90, 6, 'Fecha / Hora: ' . date('d/m/Y H:i:s', strtotime($venta['date_add_venta'])), 0, 1, 'R');
        $pdf->Ln(2);

        // Cuadro Gris: Ficha del Socio Receptor
        $pdf->SetFillColor(245, 247, 246);
        $pdf->Rect(15, $pdf->GetY(), 180, 24, 'F');
        $pdf->SetX(18);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(27, 67, 50);
        $pdf->Cell(0, 6, 'DATOS DEL MIEMBRO:', 0, 1, 'L');
        
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(18);
        $pdf->Cell(90, 5, 'Socio: ' . htmlspecialchars($venta['nombre'] . ' ' . $venta['apellidos'], ENT_QUOTES, 'ISO-8859-1'), 0, 0, 'L');
        $pdf->Cell(90, 5, 'Identificacion (Card ID): ' . htmlspecialchars($venta['card_id'] ?? 'No aportado'), 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->Cell(0, 5, 'Tipo de Operacion: Retirada de Mostrador / TPV Compartido', 0, 1, 'L');
        $pdf->Ln(6);

        // Tabla de Desglose Contable: Cabeceras
        $pdf->SetFillColor(27, 67, 50);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', '', 10);
        
        $pdf->Cell(90, 8, ' CONCEPTO / ARTICULO', 1, 0, 'L', true);
        $pdf->Cell(30, 8, 'PRECIO BASE', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'CANTIDAD', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'TOTAL DEBITO', 1, 1, 'R', true);

        // Contenido de la Fila del Producto
        $pdf->SetTextColor(0, 0, 0);
        
        $sufijo = (intval($venta['servicio_id'] ?? 2) === 1) ? ' g' : ' ud';
        
        $pdf->Cell(90, 10, ' ' . htmlspecialchars($venta['producto'], ENT_QUOTES, 'ISO-8859-1'), 1, 0, 'L');
        $pdf->Cell(30, 10, number_format($venta['precio_unitario'], 2, ',', '.') . ' ' . ((intval($venta['servicio_id'] ?? 2) === 1) ? 'e/g' : 'e/u'), 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($venta['cantidad'], 2, ',', '.') . $sufijo, 1, 0, 'C');
        
        $pdf->Cell(30, 10, number_format($venta['total'], 2, ',', '.') . ' EUR', 1, 1, 'R');

        // Cuadrante Inferior: Cierre Financiero Desglosado
        $pdf->Ln(4);
        $pdf->SetX(115);
        $pdf->Cell(50, 7, 'TOTAL NETO DEBITADO:', 0, 0, 'L');
        $pdf->Cell(30, 7, number_format($venta['total'], 2, ',', '.') . ' EUR', 0, 1, 'R');
        
        $pdf->SetX(115);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(50, 5, 'Regimen de IVA Incluido', 0, 0, 'L');
        $pdf->Cell(30, 5, '0,00 EUR', 0, 1, 'R');

        // Pie de Factura Informativo
        $pdf->SetY(260);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(2);
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell(0, 4, 'Comprobante interno emitido de forma automatizada por la Terminal de Punto de Venta GreenPower.', 0, 1, 'C');
        $pdf->Cell(0, 4, 'Este documento no constituye una factura comercial ordinaria. Operacion liquidada con cargo al deposito prepago del socio.', 0, 1, 'C');

        // Renderizamos el binario directo hacia la ventana de Firefox
        $pdf->Output('I', 'factura_simplificada_' . $venta['id_venta'] . '.pdf');
        exit;
    }
}
?>