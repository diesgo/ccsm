<?php
// /src/Views/compras/index.php
$compras = $compras ?? [];

// Extraemos los proveedores únicos para alimentar el desplegable dinámico
$proveedoresUnicos = [];
foreach ($compras as $c) {
    if (!empty($c['proveedor']) && !in_array($c['proveedor'], $proveedoresUnicos)) {
        $proveedoresUnicos[] = $c['proveedor'];
    }
}
sort($proveedoresUnicos);
?>

<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <!-- Cabecera Corporativa -->
    <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #1b4332; border-bottom: 2px solid #ffc107;">
        <h3 class="h6 fw-bold mb-0 text-white"><i class="fas fa-boxes text-warning me-2"></i> Registro Histórico de Albaranes de Compra</h3>
        <a href="<?php echo URL_ROOT; ?>/compras/crear" class="btn btn-sm btn-warning fw-bold d-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-plus-circle-fill"></i> Registrar Albarán
        </a>
    </div>

    <!-- BARRA DE HERRAMIENTAS: TRIPLE FILTRADO INTERACTIVO EN CALIENTE -->
    <div class="card-body bg-light border-bottom py-3 px-4">
        <div class="row g-3 align-items-end">
            <!-- 1. Buscador de Artículos -->
            <div class="col-12 col-md-6 col-lg-3">
                <label for="buscar-albaran-articulo" class="form-label text-secondary small fw-bold mb-1">Filtrar por Artículo</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" id="buscar-albaran-articulo" class="form-control text-dark fw-semibold" placeholder="Escribe el artículo...">
                </div>
            </div>
            
            <!-- 2. Selector de Proveedores -->
            <div class="col-12 col-md-6 col-lg-3">
                <label for="filtrar-albaran-proveedor" class="form-label text-secondary small fw-bold mb-1">Filtrar por Proveedor</label>
                <select id="filtrar-albaran-proveedor" class="form-select form-select-sm shadow-sm text-dark fw-semibold">
                    <option value="todos">-- Todos los Proveedores --</option>
                    <?php foreach ($proveedoresUnicos as $prov): ?>
                        <option value="<?php echo htmlspecialchars($prov, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($prov, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- 3. Calendario: Fecha Desde -->
            <div class="col-12 col-sm-6 col-lg-2">
                <label for="filtro-fecha-desde" class="form-label text-secondary small fw-bold mb-1">Desde Fecha</label>
                <input type="date" id="filtro-fecha-desde" class="form-control form-control-sm shadow-sm text-dark fw-semibold">
            </div>

            <!-- 4. Calendario: Fecha Hasta -->
            <div class="col-12 col-sm-6 col-lg-2">
                <label for="filtro-fecha-hasta" class="form-label text-secondary small fw-bold mb-1">Hasta Fecha</label>
                <input type="date" id="filtro-fecha-hasta" class="form-control form-control-sm shadow-sm text-dark fw-semibold">
            </div>

            <!-- Botón Limpiar Calendarios -->
            <div class="col-12 col-lg-2 text-lg-end">
                <button type="button" id="btn-limpiar-filtros" class="btn btn-sm btn-outline-secondary w-100 fw-bold shadow-sm py-1.5">
                    <i class="bi bi-eraser-fill"></i> Limpiar Filtros
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-0 bg-white">
        <?php if (empty($compras)): ?>
            <div class="text-center py-5 text-muted small">
                <i class="fas fa-receipt d-block display-5 text-muted opacity-25 mb-2"></i>
                No se registran compras ni entradas de mercancía en el historial de almacén.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small" id="tabla-historico-compras">
                    <thead class="table-light text-secondary fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                        <tr>
                            <th class="px-4 py-3" style="width: 170px;">Fecha / Hora</th>
                            <th class="py-3">Proveedor</th>
                            <th class="py-3">Artículo Surtido</th>
                            <th class="py-3 text-center">Costo Unit. (PCM)</th>
                            <th class="py-3 text-center">Cant. Recibida</th>
                            <th class="py-3 text-center">Tasa IVA</th>
                            <th class="px-4 py-3 text-end" style="width: 150px;">Total (Con IVA)</th>
                        </tr>
                    </thead>
                    <tbody id="body-historico-compras">
                        <?php foreach ($compras as $c):
                            $f = date('d/m/Y', strtotime($c['date_compra']));
                            $h = date('H:i:s', strtotime($c['date_compra']));
                            // Formato ISO plano (YYYY-MM-DD) indispensable para comparar fechas con JS
                            $fechaIso = date('Y-m-d', strtotime($c['date_compra']));
                        ?>
                            <tr class="border-bottom border-light fila-albaran" 
                                data-proveedor="<?php echo htmlspecialchars($c['proveedor'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                data-producto="<?php echo htmlspecialchars(strtolower($c['producto'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                data-fecha="<?php echo $fechaIso; ?>">
                                
                                <td class="px-4 text-muted font-monospace"><?php echo $f; ?> <span class="opacity-75 text-xs"><?php echo $h; ?></span></td>
                                <td class="fw-semibold text-dark"><?php echo htmlspecialchars($c['proveedor'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><span class="badge bg-light text-dark border px-2 py-1 fw-bold"><?php echo htmlspecialchars($c['producto'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span></td>
                                <td class="text-center font-monospace fw-bold text-secondary"><?php echo number_format($c['pcm'], 2, ',', '.'); ?> €</td>
                                <td class="text-center font-monospace fw-bold text-dark"><?php echo number_format($c['unidades'], 2, ',', '.'); ?></td>
                                <td class="text-center font-monospace text-muted"><?php echo $c['iva']; ?>%</td>
                                <td class="px-4 text-end font-monospace fw-bold text-success"><?php echo number_format($c['total'], 2, ',', '.'); ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <!-- Aviso visual si las búsquedas vacían la tabla por completo -->
                        <tr id="fila-vacia-filtros" class="d-none">
                            <td colspan="7" class="text-center py-4 text-muted small">
                                <i class="bi bi-exclamation-circle d-block mb-1 text-secondary opacity-50" style="font-size:1.25rem;"></i>
                                Ningún albarán cumple con los filtros combinados de artículo, distribuidor y rango de fechas.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- 🌟 MOTOR LOGÍSTICO TRIPLE INTERACTIVO -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputArticulo   = document.getElementById('buscar-albaran-articulo');
    const selectProveedor = document.getElementById('filtrar-albaran-proveedor');
    const inputDesde      = document.getElementById('filtro-fecha-desde');
    const inputHasta      = document.getElementById('filtro-fecha-hasta');
    const btnLimpiar      = document.getElementById('btn-limpiar-filtros');
    
    const filasAlbaran    = document.querySelectorAll('.fila-albaran');
    const filaVacia       = document.getElementById('fila-vacia-filtros');

    // Vinculamos los eventos de cambio y tipeo a la función centralizadora
    [inputArticulo, selectProveedor, inputDesde, inputHasta].forEach(el => {
        if (el) {
            el.addEventListener('input', ejecutarTripleFiltroAlmacen);
            el.addEventListener('change', ejecutarTripleFiltroAlmacen);
        }
    });

        // Acción para reiniciar las casillas de una sola pasada
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function() {
            inputArticulo.value = '';
            selectProveedor.value = 'todos';
            inputDesde.value = '';
            inputHasta.value = '';
            ejecutarTripleFiltroAlmacen();
        });
    }

    function ejecutarTripleFiltroAlmacen() {
        const textoBusqueda = inputArticulo.value.trim().toLowerCase();
        const proveedorSeleccionado = selectProveedor.value;
        const fechaDesdeVal = inputDesde.value; // YYYY-MM-DD o vacío
        const fechaHastaVal = inputHasta.value; // YYYY-MM-DD o vacío
        
        let filasVisibles = 0;

        filasAlbaran.forEach(row => {
            const prodTexto  = row.getAttribute('data-producto') || '';
            const provTexto  = row.getAttribute('data-proveedor') || '';
            const fechaTexto = row.getAttribute('data-fecha') || '';

            // 1. Condición Artículo
            const coincideArticulo = prodTexto.includes(textoBusqueda);
            
            // 2. Condición Proveedor
            const coincideProveedor = (proveedorSeleccionado === 'todos' || provTexto === proveedorSeleccionado);
            
            // 3. Condición Fechas (Cronológica)
            let coincideCronologia = true;
            if (fechaDesdeVal && fechaTexto < fechaDesdeVal) {
                coincideCronologia = false;
            }
            if (fechaHastaVal && fechaTexto > fechaHastaVal) {
                coincideCronologia = false;
            }

            // Aislamiento lógico: la fila pasa si cumple los 3 filtros simultáneamente
            if (coincideArticulo && coincideProveedor && coincideCronologia) {
                row.classList.remove('d-none');
                filasVisibles++;
            } else {
                row.classList.add('d-none');
            }
        });

        // Alternancia del mensaje si el historial se queda a cero
        if (filasVisibles === 0 && filasAlbaran.length > 0) {
            filaVacia.classList.remove('d-none');
        } else {
            filaVacia.classList.add('d-none');
        }
    }
});
</script>
