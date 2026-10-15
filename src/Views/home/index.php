<?php
// /src/Views/home/index.php
$numSocios = $numSocios ?? 0;
$numStock = $numStock ?? 0;
$capitalMonederos = $capitalMonederos ?? 0.00;
$cajaDiaria = $cajaDiaria ?? 0.00;
$datosGrafico = $datosGrafico ?? [];
$categoriasStats = $ventas_categorias ?? []; 

// Mapeamos los meses y totales para el array de Chart.js (Gráfico de Barras)
$mesesLabels = [];
$totalesValores = [];
foreach ($datosGrafico as $row) {
    $mesesLabels[] = date('m/Y', strtotime($row['mes'] . '-01'));
    $totalesValores[] = (float) $row['total'];
}

// Mapeamos las familias y totales para el array de Chart.js (Gráfico de Quesito)
$labelsQuesito = [];
$valoresQuesito = [];
foreach ($categoriasStats as $cat) {
    $labelsQuesito[]  = $cat['categoria'];
    $valoresQuesito[] = (float) $cat['total_ventas'];
}
?>

<!-- 🌟 SOLUCIÓN MAESTRA: Cargamos la librería al principio para que esté disponible en toda la página -->
<script src="<?php echo URL_ROOT; ?>/js/chart.js"></script>

<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1"><i class="fas fa-chart-pie text-success me-2"></i>Dashboard Operativo Financiero</h2>
    <p class="text-muted mb-0"><?php echo htmlspecialchars($mensaje ?? 'Balances reales en mostrador.', ENT_QUOTES, 'UTF-8'); ?></p>
</div>

<!-- 1. TARJETAS DE INDICADORES EN CALIENTE (KPIs) -->
<div class="row g-3 mb-4">
    <!-- Socios Activos -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="p-3 bg-white border rounded rounded-3 text-center shadow-sm h-100">
            <i class="bi bi-people text-success display-6 mb-2"></i>
            <h3 class="h6 text-secondary text-uppercase fw-bold mb-1" style="font-size: 11px;">Socios Activos</h3>
            <p class="h3 fw-bold text-dark font-monospace mb-0"><?php echo $numSocios; ?></p>
        </div>
    </div>

    <!-- Stock Dispensario -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="p-3 bg-white border rounded rounded-3 text-center shadow-sm h-100">
            <i class="bi bi-box-seam text-primary display-6 mb-2"></i>
            <h3 class="h6 text-secondary text-uppercase fw-bold mb-1" style="font-size: 11px;">Stock Dispensario</h3>
            <p class="h3 fw-bold text-dark font-monospace mb-0"><?php echo number_format($numStock, 1, ',', '.'); ?></p>
        </div>
    </div>

    <!-- Depósitos Prepago -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="p-3 bg-white border rounded rounded-3 text-center shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
            <i class="bi bi-wallet2 text-warning display-6 mb-2"></i>
            <h3 class="h6 text-secondary text-uppercase fw-bold mb-1" style="font-size: 11px;">Depósitos Prepago</h3>
            <p class="h3 fw-bold text-success font-monospace mb-0"><?php echo number_format($capitalMonederos, 2, ',', '.'); ?> €</p>
        </div>
    </div>

    <!-- Caja del Día -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="p-3 bg-success-subtle border border-success-subtle rounded rounded-3 text-center shadow-sm h-100">
            <i class="bi bi-cash-coin text-success display-6 mb-2"></i>
            <h3 class="h6 text-success-emphasis text-uppercase fw-bold mb-1" style="font-size: 11px;">Caja del Día</h3>
            <p class="h3 fw-bold text-success font-monospace mb-0"><?php echo number_format($cajaDiaria, 2, ',', '.'); ?> €</p>
        </div>
    </div>
</div>

<!-- 2. REJILLA BALANCEADA EN PARALELO DE GRÁFICOS CONTABLES -->
<div class="row g-4 mb-4">
    <!-- Panel Izquierdo: Histórico de Barras Mensuales -->
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="fas fa-chart-bar text-success me-2"></i>Estadística de Dispensación (Últimos Meses)</h3>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                <?php if (empty($datosGrafico)): ?>
                    <div class="text-center text-muted py-5 small">
                        <i class="fas fa-chart-line display-6 d-block mb-2 opacity-25"></i>
                        No hay suficientes datos registrados en el historial de ventas para generar curvas contables.
                    </div>
                <?php else: ?>
                    <div style="width: 100%; min-height: 230px; max-height: 250px; position: relative;">
                        <canvas id="chartFinanzas"></canvas>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Panel Derecho: Distribución por Categorías / Quesito DUAL -->
    <div class="col-12 col-lg-5">
        <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Distribución por Familias de Productos</h3>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                <?php if (empty($categoriasStats)): ?>
                    <div class="text-center text-muted py-5 small">
                        <i class="bi bi-pie-chart d-block display-6 mb-2 opacity-25"></i>
                        No se registran transacciones suficientes para segmentar las familias.
                    </div>
                <?php else: ?>
                    <div style="width: 100%; min-height: 230px; max-height: 250px; position: relative;" class="d-flex justify-content-center">
                        <canvas id="chartCategoriasQuesito"></canvas>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- 3. PANEL DE OPERACIONES RÁPIDAS (Se desplaza abajo para dar espacio horizontal a los gráficos) -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="fas fa-rocket text-success me-2"></i>Operaciones Rápidas de Terminal</h3>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-12 col-md-4">
                        <a href="<?php echo URL_ROOT; ?>/dispensario" class="btn btn-success fw-bold text-warning w-100 py-2.5 shadow-sm text-start" style="background-color: #1b4332; border:none;">
                            <i class="fas fa-cash-register me-2"></i> Abrir Terminal TPV (Mostrador)
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="<?php echo URL_ROOT; ?>/socios" class="btn btn-outline-secondary fw-bold w-100 py-2.5 text-start">
                            <i class="fas fa-user-plus me-2"></i> Alta / Inscripción de Socios
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="<?php echo URL_ROOT; ?>/productos" class="btn btn-outline-secondary fw-bold w-100 py-2.5 text-start">
                            <i class="fas fa-box-open me-2"></i> Ajustar Inventario de Almacén
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. AUDITORÍA GENERAL DE CAJA DIARIA EN TIEMPO REAL -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #1b4332; border-bottom: 2px solid #ffc107;">
                <h3 class="h6 fw-bold mb-0 text-white"><i class="fas fa-history text-warning me-2"></i>Monitoreo de Caja: Movimientos de Dispensación en Tiempo Real</h3>
                <span class="badge bg-warning text-dark rounded-pill fw-bold small px-3">Hoy</span>
            </div>
            <div class="card-body p-0 bg-white">
                <?php if (empty($datosGrafico)): ?>
                    <div class="text-center py-5 text-muted small">
                        <i class="fas fa-folder-open d-block display-6 opacity-25 mb-2"></i>
                        No se registran movimientos en las balanzas ni en la cesta en la jornada de hoy.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light text-secondary fw-bold text-uppercase" style="font-size: 11px;">
                                <tr>
                                    <th class="px-4 py-2.5">Fecha / Hora</th>
                                    <th class="py-2.5">Socio / Miembro del Club</th>
                                    <th class="py-2.5">Artículo despachado</th>
                                    <th class="py-2.5 text-center">Cantidad</th>
                                    <th class="px-4 py-2.5 text-end">Costo Debitado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $movimientosPortada = Venta::obtenerVentasDelDia();
                                foreach ($movimientosPortada as $m):
                                    $fechaFormato = date('d/m/Y', strtotime($m['date_add_venta']));
                                    $horaFormato = date('H:i:s', strtotime($m['date_add_venta']));
                                ?>
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 text-muted font-monospace" style="white-space:nowrap;">
                                            <?php echo $fechaFormato; ?> <span class="text-xs text-secondary opacity-75"><?php echo $horaFormato; ?></span>
                                        </td>
                                        <td class="fw-semibold text-dark"><?php echo htmlspecialchars($m['socio_nombre'] . ' ' . $m['socio_apellidos'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span class="badge bg-light text-dark border px-2 py-1 fw-bold"><?php echo htmlspecialchars($m['producto'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                        <td class="text-center font-monospace text-secondary fw-bold">
                                            <?php echo number_format($m['cantidad'], 2, ',', '.'); ?>
                                            <small class="text-muted"><?php echo (intval($m['servicio_id'] ?? 2) === 1) ? 'g' : 'ud'; ?></small>
                                        </td>
                                        <td class="px-4 text-end font-monospace fw-bold text-danger">-<?php echo number_format($m['importe_total'], 2, ',', '.'); ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === GRÁFICO 1: BARRAS MENSUALES ORIGINAL ===
    const ctxBarras = document.getElementById('chartFinanzas');
    if (ctxBarras) {
        new Chart(ctxBarras, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($mesesLabels); ?>,
                datasets: [{
                    label: 'Volumen Dispensado (€)',
                    data: <?php echo json_encode($totalesValores); ?>,
                    backgroundColor: 'rgba(45, 90, 39, 0.85)', 
                    borderColor: '#1b4332',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return value + ' €'; },
                            font: { family: 'monospace' }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // === GRÁFICO 2: DOUGHNUT/QUESITO POR CATEGORÍAS EN PARALELO ===
    const ctxQuesito = document.getElementById('chartCategoriasQuesito');
    if (ctxQuesito) {
        new Chart(ctxQuesito, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labelsQuesito); ?>,
                datasets: [{
                    data: <?php echo json_encode($valoresQuesito); ?>,
                    backgroundColor: [
                        '#1b4332', // Verde forestal
                        '#ffc107', // Ocre
                        '#2a9d8f', // Turquesa
                        '#e76f51', // Coral
                        '#457b9d', // Azul
                        '#a8dadc'  // Menta
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            font: { size: 10 },
                            padding: 8
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
});
</script>
