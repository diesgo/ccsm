<?php 
// /src/Views/variedades/edit.php
$v = $variedad ?? []; 
?>
<!-- Botón superior ágil para regresar de forma segura al listado principal -->
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/variedades" class="btn btn-outline-secondary btn-sm fw-bold d-inline-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>
</div>

<!-- Tarjeta Principal del Formulario de Edición -->
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-pencil-square text-warning"></i> Modificar Variedad / Tipo #<?php echo $v['id_variedad']; ?>
        </h2>
    </div>
    
    <div class="card-body p-4">
        <form action="<?php echo URL_ROOT; ?>/variedades/actualizar" method="POST" autocomplete="off">
            <!-- ID oculto indispensable para que el controlador ejecute el UPDATE relacional en MariaDB -->
            <input type="hidden" name="id_variedad" value="<?php echo $v['id_variedad']; ?>">

            <div class="row g-3 mb-4">
                <!-- Campo: Nombre de la Variedad -->
                <div class="col-12 col-md-6">
                    <label for="variedad" class="form-label small fw-bold text-secondary">Clasificación / Tipo *</label>
                    <input type="text" name="variedad" id="variedad" class="form-control fw-bold" 
                           value="<?php echo htmlspecialchars($v['variedad'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <!-- Campo: Descripción Opcional -->
                <div class="col-12 col-md-8">
                    <label for="descripcion_variedad" class="form-label small fw-bold text-secondary">Descripción de la Clasificación</label>
                    <textarea name="descripcion_variedad" id="descripcion_variedad" class="form-control" rows="3" 
                              placeholder="Detalles sobre este tipo de artículo comercial..."><?php echo htmlspecialchars($v['descripcion_variedad'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
            </div>
            <!-- Botones de Control Operativo con Bootstrap Icons -->
            <div class="pt-3 border-top d-flex gap-2">
                <a href="<?php echo URL_ROOT; ?>/variedades" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-clockwise"></i> Actualizar Tipo
                </button>
            </div>
        </form>
    </div>
</div>
