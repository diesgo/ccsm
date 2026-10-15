<?php
$proveedores = $proveedores ?? [];
$puedeCrearProveedor = (intval($_SESSION['perfil_id'] ?? 0) === 1) || (intval($_SESSION['permisos']['crear_proveedores'] ?? 0) === 1);
?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1"><i class="fas fa-truck text-dark me-2"></i>Gestión de Proveedores</h2>
    <p class="text-muted mb-0">Administración de empresas mayoristas y suministradoras del dispensario</p>
</div>

<div class="row g-4">
    <!-- Tabla de Registros -->
    <div class="col-12 <?php echo $puedeCrearProveedor ? 'col-md-8' : ''; ?>">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="px-4 py-3" style="width: 100px;">ID</th>
                                <th class="py-3">Empresa / Proveedor</th>
                                <th class="py-3">Descripción comercial</th>
                                <th class="px-4 py-3 text-center" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proveedores as $p): ?>
                                <tr>
                                    <td class="px-4 text-muted font-monospace fw-bold">#<?php echo $p['id_proveedor']; ?></td>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($p['proveedor'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-muted small"><?php echo htmlspecialchars($p['descripcion_proveedor'] ?? 'Sin notas comerciales', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="px-4 text-center">
                                        <a href="<?php echo URL_ROOT; ?>/proveedores/editar?id=<?php echo $p['id_proveedor']; ?>" 
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

    <!-- Panel de Alta Rápida Lateral -->
    <?php if ($puedeCrearProveedor): ?>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="fas fa-plus-circle text-success me-1"></i> Añadir Proveedor</h3>
            </div>
            <div class="card-body p-3">
                <form action="<?php echo URL_ROOT; ?>/proveedores/guardar" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="proveedor" class="form-label small fw-bold text-secondary">Razón Social / Nombre *</label>
                        <input type="text" name="proveedor" id="proveedor" class="form-control" placeholder="Ej: Distribuciones Norte S.A." required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_proveedor" class="form-label small fw-bold text-secondary">Descripción Comercial</label>
                        <textarea name="descripcion_proveedor" id="descripcion_proveedor" class="form-control" rows="3" placeholder="Teléfonos, días de reparto, condiciones de pago..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success fw-bold w-100 py-2 shadow-sm">
                        <i class="fas fa-save me-1"></i> Registrar Empresa
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
