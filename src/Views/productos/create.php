<?php
// /src/Views/productos/create.php
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
        <h2 class="h5 fw-bold text-dark mb-0"><i class="fas fa-plus-circle text-primary me-2"></i>Registrar Nuevo Artículo en Inventario</h2>
    </div>
    <div class="card-body p-4">

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- REVISA ESTA LÍNEA: Es obligatorio incluir el enctype para que procese $_FILES -->
        <form action="<?php echo URL_ROOT; ?>/productos/guardar" method="POST" enctype="multipart/form-data" autocomplete="off">

            <div class="row g-3">

                <!-- Nombre del Producto -->
                <div class="col-12 col-md-6">
                    <label for="producto" class="form-label small fw-bold text-secondary">Nombre del Producto *</label>
                    <input type="text" name="producto" id="producto" class="form-control" placeholder="Ej: Fanta Limón Lata" required>
                </div>

                <!-- Categoría (Dinámica) -->
                <div class="col-12 col-md-6">
                    <label for="categoria_id" class="form-label small fw-bold text-secondary">Categoría *</label>
                    <select name="categoria_id" id="categoria_id" class="form-select" required>
                        <option value="">Seleccione una categoría...</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id_categoria']; ?>">
                                <?php echo htmlspecialchars($cat['categoria'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Variedad / Tipo (Dinámico) -->
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

                <!-- Impuesto (Dinámico) -->
                <div class="col-12 col-md-6">
                    <label for="impuesto_id" class="form-label small fw-bold text-secondary">Tasa de Impuesto / IVA *</label>
                    <select name="impuesto_id" id="impuesto_id" class="form-select" required>
                        <option value="">Seleccione una tasa de impuesto...</option>
                        <?php foreach ($impuestos as $imp): ?>
                            <!-- Comparamos el ID de la tabla impuestos contra el guardado en el producto -->
                            <option value="<?php echo $imp['id_impuesto']; ?>" <?php echo (intval($imp['id_impuesto']) === intval($producto['impuesto_id'] ?? 1)) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($imp['impuesto'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- Precio de Venta al Público (PVP) -->
                <div class="col-12 col-md-4">
                    <label for="pvp" class="form-label small fw-bold text-secondary">Precio de Venta (PVP con IVA)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="pvp" id="pvp" class="form-control" placeholder="0.00" value="0.00">
                        <span class="input-group-text bg-light text-muted">€</span>
                    </div>
                </div>

                <!-- Precio de compra y orientativo -->
                <div class="col-12 col-md-4">
                    <label for="precio_compra" class="form-label small fw-bold text-secondary">Precio de Compra (opcional)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" name="precio_compra" id="precio_compra" class="form-control" placeholder="0.00" value="">
                        <span class="input-group-text bg-light text-muted">€</span>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <label for="precio_orientativo" class="form-label small fw-bold text-secondary">
                        Precio Orientativo (+<?php echo rtrim(rtrim(number_format((float) ($margen ?? 30), 2, '.', ''), '0'), '.'); ?>% beneficio)
                    </label>
                    <div class="input-group">
                        <input type="text" id="precio_orientativo" class="form-control bg-light" value="—" readonly tabindex="-1" data-margen="<?php echo (float) ($margen ?? 30); ?>">
                        <span class="input-group-text bg-light text-muted">€</span>
                    </div>
                    <small class="text-muted">Solo informativo. Se configura en Configuración del sistema.</small>
                </div>

                <!-- Stock Inicial en Mostrador -->
                <div class="col-12 col-md-4">
                    <label for="dispensario" class="form-label small fw-bold text-secondary">Existencias Iniciales en Dispensario</label>
                    <input type="number" step="0.01" name="dispensario" id="dispensario" class="form-control" value="0.00">
                </div>

                <!-- Subir Imagen Binaria -->
                <div class="col-12 col-md-4">
                    <label for="imagen_producto" class="form-label small fw-bold text-secondary">Fotografía del Producto</label>
                    <input type="file" name="imagen_producto" id="imagen_producto" class="form-control" accept="image/jpeg,image/png,image/webp">
                </div>

                <!-- Visibilidad en Catálogo -->
                <div class="col-12">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-switch form-check-input" type="checkbox" name="visible" id="visible" checked value="1">
                        <label class="form-check-label small fw-bold text-dark" for="visible">Habilitar visibilidad inmediata en el mostrador de ventas</label>
                    </div>
                </div>

            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?php echo URL_ROOT; ?>/productos" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Registrar Producto
                </button>
            </div>
        </form>

    </div>
</div>
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
