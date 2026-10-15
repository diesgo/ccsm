<?php
// /src/Views/productos/edit.php
$p = $producto ?? [];
$categorias = $categorias ?? [];
$variedades = $variedades ?? [];
$servicios = $servicios ?? [];
$impuestos = $impuestos ?? [];
?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/productos" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver al inventario
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0"><i class="fas fa-edit text-warning me-2"></i>Modificar Artículo: <?php echo htmlspecialchars($p['producto'], ENT_QUOTES, 'UTF-8'); ?></h2>
    </div>
    <div class="card-body p-4">

        <form action="<?php echo URL_ROOT; ?>/productos/actualizar" method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- Campo oculto imprescindible para saber qué ID estamos editando -->
            <input type="hidden" name="id_producto" value="<?php echo $p['id_producto']; ?>">

            <div class="row g-3">
                <!-- Nombre del Producto -->
                <div class="col-12 col-md-6">
                    <label for="producto" class="form-label small fw-bold text-secondary">Nombre del Producto *</label>
                    <input type="text" name="producto" id="producto" class="form-control" value="<?php echo htmlspecialchars($p['producto'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Categoría -->
                <div class="col-12 col-md-6">
                    <label for="categoria_id" class="form-label small fw-bold text-secondary">Categoría *</label>
                    <select name="categoria_id" id="categoria_id" class="form-select" required>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id_categoria']; ?>" <?php echo $cat['id_categoria'] == $p['categoria_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['categoria'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Variedad -->
                <div class="col-12 col-md-6">
                    <label for="variedad_id" class="form-label small fw-bold text-secondary">Variedad / Clasificación</label>
                    <select name="variedad_id" id="variedad_id" class="form-select">
                        <option value="">Sin variedad</option>
                        <?php foreach ($variedades as $v): ?>
                            <!-- Comparamos el ID del bucle contra el asignado en tu tabla productos -->
                            <option value="<?php echo $v['id_variedad']; ?>" <?php echo (intval($v['id_variedad']) === intval($producto['variedad_id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($v['variedad'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Selector de IVA alimentado dinámicamente con tu tabla real de phpMyAdmin -->
                <div class="col-12 col-md-4">
                    <label for="impuesto_id" class="form-label small fw-bold text-secondary">Tasa de Impuesto / IVA *</label>
                    <select name="impuesto_id" id="impuesto_id" class="form-select fw-bold text-dark" required>
                        <?php if (!empty($impuestos) && is_array($impuestos)): ?>
                            <?php foreach ($impuestos as $imp): ?>
                                <option value="<?php echo $imp['id_impuesto']; ?>"
                                    <?php echo (intval($producto['impuesto_id'] ?? 7) === intval($imp['id_impuesto'])) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($imp['impuesto'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Valor de respaldo por si la base de datos se desconectara -->
                            <option value="7">Sin impuestos (0%)</option>
                        <?php endif; ?>
                    </select>
                </div>

                <?php
                // CORRECCIÓN MAESTRA: Validamos de forma estricta las dos variables que inyecta el controlador
                // Asegúrate de usar el nombre exacto de la variable del producto (normalmente $producto o $p)
                $prodActual = $producto ?? $p ?? [];
                $idCategoriaProducto = intval($prodActual['categoria_id'] ?? 0);

                $esGranel = false;
                if (isset($categorias) && is_array($categorias)) {
                    foreach ($categorias as $cat) {
                        // Buscamos la coincidencia de la familia y leemos su servicio_id (1 = Granel)
                        if (intval($cat['id_categoria']) === $idCategoriaProducto && intval($cat['servicio_id'] ?? 2) === 1) {
                            $esGranel = true;
                            break;
                        }
                    }
                }
                ?>

                <div class="row g-3 mb-4">
                    <!-- Campo: Precio de Venta Adaptable -->
                    <div class="col-12 col-md-4">
                        <label for="pvp" class="form-label small fw-bold text-secondary">
                            <?php echo $esGranel ? 'Tarifa por Gramo (PVP con IVA) *' : 'Precio Unitario (PVP con IVA) *'; ?>
                        </label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="pvp" id="pvp" class="form-control fw-bold font-monospace text-dark"
                                value="<?php echo htmlspecialchars($prodActual['pvp'] ?? '0.00', ENT_QUOTES, 'UTF-8'); ?>" required>
                            <span class="input-group-text bg-light fw-bold text-secondary" id="addon-pvp">
                                <?php echo $esGranel ? '€ / gr' : '€ / ud'; ?>
                            </span>
                        </div>
                    </div>

                    <!-- Precio de compra y orientativo -->
                    <div class="col-12 col-md-4">
                    <label for="precio_compra" class="form-label small fw-bold text-secondary">Precio de Compra (opcional)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" name="precio_compra" id="precio_compra" class="form-control fw-bold font-monospace text-dark" placeholder="0.00" value="<?php echo htmlspecialchars($prodActual['precio_compra'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <span class="input-group-text bg-light text-muted">€</span>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <label for="precio_orientativo" class="form-label small fw-bold text-secondary">
                        Precio Orientativo (+<?php echo rtrim(rtrim(number_format((float) ($margen ?? 30), 2, '.', ''), '0'), '.'); ?>% beneficio)
                    </label>
                    <div class="input-group">
                        <input type="text" id="precio_orientativo" class="form-control fw-bold font-monospace text-dark bg-light" value="—" readonly tabindex="-1" data-margen="<?php echo (float) ($margen ?? 30); ?>">
                        <span class="input-group-text bg-light text-muted">€</span>
                    </div>
                    <small class="text-muted">Solo informativo. Se configura en Configuración del sistema.</small>
                </div>

                    <!-- Campo: Stock en Dispensario Adaptable -->
                    <div class="col-12 col-md-4">
                        <label for="dispensario" class="form-label small fw-bold text-secondary">
                            <?php echo $esGranel ? 'Peso Total en Dispensario (Gramos) *' : 'Unidades Totales en Dispensario *'; ?>
                        </label>
                        <div class="input-group">
                            <input type="number" step="<?php echo $esGranel ? '0.01' : '1'; ?>" name="dispensario" id="dispensario"
                                class="form-control fw-bold font-monospace text-dark"
                                value="<?php echo htmlspecialchars($prodActual['dispensario'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>" required>
                            <span class="input-group-text bg-light fw-bold text-secondary" id="addon-stock">
                                <?php echo $esGranel ? 'gr' : 'ud'; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Subir nueva foto y previsualizar la actual -->
                <div class="col-12 col-md-4">
                    <label for="imagen_producto" class="form-label small fw-bold text-secondary">Actualizar Fotografía</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="border rounded bg-light d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; overflow:hidden;">
                            <img src="<?php echo htmlspecialchars(Demo::urlImagen('productos', $p['imagen_producto']), ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid" style="object-fit: cover; width:100%; height:100%;">
                        </div>
                        <input type="file" name="imagen_producto" id="imagen_producto" class="form-control">
                    </div>
                </div>

                <!-- Visibilidad -->
                <div class="col-12">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="visible" id="visible" value="1" <?php echo $p['visible'] == 1 ? 'checked' : ''; ?>>
                        <label class="form-check-label small fw-bold text-dark" for="visible">Este artículo está visible para la venta en el mostrador</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?php echo URL_ROOT; ?>/productos" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                    <i class="fas fa-sync-alt me-1"></i> Actualizar Producto
                </button>
            </div>
        </form>
        <script>

    (function () {
        const compra = document.getElementById('precio_compra');
        const orient = document.getElementById('precio_orientativo');
        if (!compra || !orient) return;
        const margen = parseFloat(orient.dataset.margen) || 0;
        function calcular() {
            const v = parseFloat(compra.value);
            orient.value = isNaN(v) ? '—' : (v * (1 + margen / 100)).toFixed(2);
        }
        compra.addEventListener('input', calcular);
        calcular();
    })();
</script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectCategoria = document.getElementById('categoria_id') || document.querySelector('select[name="categoria_id"]');
                const labelPvp = document.querySelector('label[for="pvp"]');
                const addonPvp = document.getElementById('addon-pvp');
                const labelStock = document.querySelector('label[for="dispensario"]');
                const addonStock = document.getElementById('addon-stock');
                const inputStock = document.getElementById('dispensario');

                // PHP nos sopla cuáles categorías son a granel inyectando un array nativo en JS
                const categoriasGranel = [
                    <?php
                    if (isset($categorias)) {
                        foreach ($categorias as $cat) {
                            if (intval($cat['servicio_id'] ?? 2) === 1) {
                                echo $cat['id_categoria'] . ',';
                            }
                        }
                    }
                    ?>
                ];

                if (selectCategoria) {
                    selectCategoria.addEventListener('change', function() {
                        const idSeleccionado = parseInt(this.value);
                        const esGranel = categoriasGranel.includes(idSeleccionado);

                        // Cambiamos las etiquetas y sufijos en caliente en el DOM
                        if (esGranel) {
                            if (labelPvp) labelPvp.textContent = 'Tarifa por Gramo (PVP con IVA) *';
                            if (addonPvp) addonPvp.textContent = '€ / gr';
                            if (labelStock) labelStock.textContent = 'Peso Total en Dispensario (Gramos) *';
                            if (addonStock) addonStock.textContent = 'gr';
                            if (inputStock) inputStock.setAttribute('step', '0.01');
                        } else {
                            if (labelPvp) labelPvp.textContent = 'Precio Unitario (PVP con IVA) *';
                            if (addonPvp) addonPvp.textContent = '€ / ud';
                            if (labelStock) labelStock.textContent = 'Unidades Totales en Dispensario *';
                            if (addonStock) addonStock.textContent = 'ud';
                            if (inputStock) {
                                inputStock.setAttribute('step', '1');
                                inputStock.value = Math.floor(parseFloat(inputStock.value || 0));
                            }
                        }
                    });
                }
            });
        </script>
    </div>
</div>