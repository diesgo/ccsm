<?php
// /src/Views/cuotas/edit.php
$c = $cuota ?? [];
?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/cuotas" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver a Cuotas
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0"><i class="fas fa-edit text-warning me-2"></i>Ajustar Parámetros de Tarifa: #<?php echo $c['id_cuota']; ?></h2>
    </div>
    <div class="card-body p-4 bg-white">
        
        <form action="<?php echo URL_ROOT; ?>/cuotas/actualizar" method="POST" autocomplete="off">
            <!-- ID oculto indispensable para el UPDATE condicional en MariaDB -->
            <input type="hidden" name="id_cuota" value="<?php echo $c['id_cuota']; ?>">

            <div class="row g-3 mb-4">
                <!-- Concepto de la Cuota -->
                <div class="col-12 col-md-6">
                    <label for="nombre_cuota" class="form-label small fw-bold text-secondary">Nombre de la Cuota / Concepto *</label>
                    <input type="text" name="nombre_cuota" id="nombre_cuota" class="form-control fw-bold" value="<?php echo htmlspecialchars($c['nombre_cuota'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Importe Monetario -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="importe" class="form-label small fw-bold text-secondary">Importe Mensual / Periódico (€) *</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" name="importe" id="importe" class="form-control font-monospace fw-bold text-success" value="<?php echo $c['importe'] ?? 0; ?>" required>
                        <span class="input-group-text bg-light fw-bold">€</span>
                    </div>
                </div>

                <!-- Interruptor de Activación -->
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label small fw-bold text-secondary d-block">Estado de la Tarifa</label>
                    <div class="form-check form-switch mt-2 fs-5">
                        <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" <?php echo intval($c['activo'] ?? 0) === 1 ? 'checked' : ''; ?> style="cursor: pointer;">
                        <label class="form-check-label <?php echo intval($c['activo'] ?? 0) === 1 ? 'text-success' : 'text-danger'; ?> fw-bold small ms-1" for="activo" style="font-size: 12px; vertical-align: middle;">
                            <?php echo intval($c['activo'] ?? 0) === 1 ? 'Vigente / Disponible' : 'Suspendida / Desactivada'; ?>
                        </label>
                    </div>
                </div>
            </div>

            <!-- BOTONERA DE ACCIÓN -->
            <div class="pt-3 border-top d-flex gap-2">
                <a href="<?php echo URL_ROOT; ?>/cuotas" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                    <i class="fas fa-sync-alt me-1"></i> Actualizar Tarifa
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkActivo = document.getElementById('activo');
    if (checkActivo) {
        checkActivo.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.checked) {
                label.textContent = "Vigente / Disponible";
                label.className = "form-check-label text-success fw-bold small ms-1";
            } else {
                label.textContent = "Suspendida / Desactivada";
                label.className = "form-check-label text-danger fw-bold small ms-1";
            }
        });
    }
});
</script>
