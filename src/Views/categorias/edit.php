<?php $c = $categoria ?? []; ?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/categorias" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0"><i class="fas fa-edit text-warning me-2"></i>Modificar Categoría #<?php echo $c['id_categoria']; ?></h2>
    </div>
    <div class="card-body p-4">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form action="<?php echo URL_ROOT; ?>/categorias/actualizar" method="POST" autocomplete="off">
            <input type="hidden" name="id_categoria" value="<?php echo $c['id_categoria']; ?>">

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                    <label for="categoria" class="form-label small fw-bold text-secondary">Nombre de la Categoría *</label>
                    <input type="text" name="categoria" id="categoria" class="form-control fw-bold" value="<?php echo htmlspecialchars($c['categoria'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" <?php echo ($c['activo'] ?? 0) == 1 ? 'checked' : ''; ?>>
                        <label class="form-check-label small fw-bold text-dark" for="activo">Categoría activa (Disponible para asignar en productos)</label>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label for="servicio_id" class="form-label small fw-bold text-secondary">Naturaleza de Despacho *</label>
                <select name="servicio_id" id="servicio_id" class="form-select fw-bold" required>
                    <option value="2" <?php echo (intval($c['servicio_id'] ?? 2) === 2) ? 'selected' : ''; ?>>Por Unidades fijas (ud)</option>
                    <option value="1" <?php echo (intval($c['servicio_id'] ?? 2) === 1) ? 'selected' : ''; ?>>Al Peso / Granel (g)</option>
                </select>
                <div class="form-text text-muted small mt-1">Todos los artículos de esta categoría heredarán esta métrica de venta en la caja.</div>
            </div>
            <?php
            $iconoSeleccionado = $c['icono'] ?? '';
            include __DIR__ . '/selector-icono.php';
            ?>
            <div class="pt-3 border-top d-flex gap-2">
                <a href="<?php echo URL_ROOT; ?>/categorias" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                    <i class="fas fa-sync-alt me-1"></i> Actualizar Categoría
                </button>
            </div>
        </form>
    </div>
</div>