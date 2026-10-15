<?php
// /src/Controllers/HomeController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Socio.php';
require_once ROOT_PATH . '/src/Models/Producto.php';
require_once ROOT_PATH . '/src/Models/Venta.php';

class HomeController extends Controller
{
    public function index()
    {
        // 🌟 CANDADO DE INMUNIDAD CRÍTICA: 
        // Si no es Administrador Supremo (Perfil 1), rebota al usuario hacia el dispensario de forma fulminante
        if (intval($_SESSION['perfil_id'] ?? 0) !== 1) {
            header('Location: ' . URL_ROOT . '/dispensario');
            exit;
        }

        // Extraer métricas de volumen y operativas desde tus modelos reales
        $totalSocios = Socio::countActivos();
        $totalExistencias = Producto::countInventario();

        // 🌟 EXTRACCIÓN RELACIONAL DE CATEGORÍAS PARA LA ROSA DE CHART.JS
        $ventasCategorias = Venta::obtenerVentasPorCategoria();

        // Renderizar el Dashboard pasando las variables financieras y la nueva matriz rbac analítica
        $this->render('home/index', [
            'titulo'            => 'Panel de Control - GreenPower',
            'mensaje'           => 'Resumen financiero consolidado y balance contable del club.',
            'numSocios'         => $totalSocios,
            'numStock'          => $totalExistencias,
            'capitalMonederos'  => Venta::totalMonederos(),
            'cajaDiaria'        => Venta::facturacionHoy(),
            'datosGrafico'      => Venta::balanceMensualHistorico(),
            'ventas_categorias' => $ventasCategorias // 🌟 LÍNEA CRUCIAL: Inyectamos los gajos de facturación reales
        ]);
    }
}
?>