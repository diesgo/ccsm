<?php
$variedades = $variedades ?? [];
$puedeCrearVariedad = (intval($_SESSION['perfil_id'] ?? 0) === 1) || (intval($_SESSION['permisos']['crear_variedades'] ?? 0) === 1);
?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1"><i class="fas fa-seedling text-success me-2"></i>Variedades y Tipos de Artículo</h2>
    <p class="text-muted mb-0">Administración de subtipos y clasificaciones para los productos del catálogo</p>
</div>

<div class="row g-4">
    <div class="col-12 <?php echo $puedeCrearVariedad ? 'col-md-8' : ''; ?>">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="px-4 py-3" style="width: 100px;">ID</th>
                                <th class="py-3">Clasificación / Tipo</th>
                                <th class="py-3">Descripción</th>
                                <th class="px-4 py-3 text-center" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($variedades as $v): ?>
                                <tr>
                                    <td class="px-4 text-muted fw-bold">#<?php echo $v['id_variedad']; ?></td>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($v['variedad'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-muted small"><?php echo htmlspecialchars($v['descripcion_variedad'] ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="px-4 text-center">
                                        <a href="<?php echo URL_ROOT; ?>/variedades/editar?id=<?php echo $v['id_variedad']; ?>" 
                                           class="btn btn-sm btn-outline-warning text-dark fw-bold shadow-sm d-inline-flex align-items-center gap-1">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Alta Rápida Lateral -->
    <?php if ($puedeCrearVariedad): ?>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="fas fa-plus-circle text-success me-1"></i> Nueva Variedad</h3>
            </div>
            <div class="card-body p-3">
                <form action="<?php echo URL_ROOT; ?>/variedades/guardar" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="variedad" class="form-label small fw-bold text-secondary">Nombre del Tipo *</label>
                        <input type="text" name="variedad" id="variedad" class="form-control" placeholder="Ej: Extra Dulce" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_variedad" class="form-label small fw-bold text-secondary">Descripción Opcional</label>
                        <textarea name="descripcion_variedad" id="descripcion_variedad" class="form-control" rows="2" placeholder="Detalles de la clasificación..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success fw-bold w-100 py-2 shadow-sm">
                        <i class="fas fa-save me-1"></i> Guardar Variedad
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
