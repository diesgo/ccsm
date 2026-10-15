<?php 
// /src/Views/proveedores/edit.php
$p = $proveedor ?? []; 
?>
<!-- Botón para regresar de forma segura al listado principal -->
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/proveedores" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<!-- Tarjeta Principal del Formulario -->
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0">
            <i class="fas fa-edit text-warning me-2"></i>Modificar Datos del Proveedor #<?php echo $p['id_proveedor']; ?>
        </h2>
    </div>
    
    <div class="card-body p-4">
        <form action="<?php echo URL_ROOT; ?>/proveedores/actualizar" method="POST" autocomplete="off">
            <!-- ID oculto indispensable para que el controlador ejecute el UPDATE en MariaDB -->
            <input type="hidden" name="id_proveedor" value="<?php echo $p['id_proveedor']; ?>">

            <div class="row g-3 mb-4">
                <!-- Campo: Razón Social / Nombre -->
                <div class="col-12 col-md-6">
                    <label for="proveedor" class="form-label small fw-bold text-secondary">Razón Social / Nombre Comercial *</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control fw-bold" 
                           value="<?php echo htmlspecialchars($p['proveedor'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <!-- Campo: Descripción Comercial / Notas -->
                <div class="col-12 col-md-8">
                    <label for="descripcion_proveedor" class="form-label small fw-bold text-secondary">Descripción Comercial y Notas de Reparto</label>
                    <textarea name="descripcion_proveedor" id="descripcion_proveedor" class="form-control" rows="4" 
                              placeholder="Teléfonos de contacto, condiciones de facturación, días fijos de visita..."><?php echo htmlspecialchars($p['descripcion_proveedor'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
            </div>

            <!-- Botones de Acción e Interactividad Visual -->
            <div class="pt-3 border-top d-flex gap-2">
                <a href="<?php echo URL_ROOT; ?>/proveedores" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                    <i class="fas fa-sync-alt me-1"></i> Actualizar Proveedor
                </button>
            </div>
        </form>
    </div>
</div>
