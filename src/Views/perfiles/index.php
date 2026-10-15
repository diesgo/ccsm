<?php
$perfiles = $perfiles ?? [];
$puedeCrearRol = (intval($_SESSION['perfil_id'] ?? 0) === 1) || (intval($_SESSION['permisos']['crear_roles'] ?? 0) === 1);
?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1"><i class="fas fa-user-tag text-info me-2"></i>Roles y Perfiles del Sistema</h2>
    <p class="text-muted mb-0">Gestión de rangos de membresías para socios y niveles de acceso para empleados</p>
</div>

<div class="row g-4">
    <!-- Tabla de Roles Existentes -->
    <div class="col-12 <?php echo $puedeCrearRol ? 'col-md-8' : ''; ?>">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="px-4 py-3" style="width: 100px;">ID</th>
                                <th class="py-3">Nombre del Rol</th>
                                <th class="px-4 py-3 text-center" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($perfiles as $p): ?>
                                <tr>
                                    <td class="px-4 text-muted fw-bold">#<?php echo $p['id_perfil']; ?></td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase fw-bold px-3 py-1.5 rounded-pill">
                                            <?php echo htmlspecialchars($p['perfil'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <a href="<?php echo URL_ROOT; ?>/perfiles/editar?id=<?php echo $p['id_perfil']; ?>" 
                                           class="btn btn-sm btn-outline-warning text-dark fw-bold shadow-sm d-inline-flex align-items-center gap-1" title="Editar Nombre">
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

    <!-- Formulario de Creación Rápida -->
    <?php if ($puedeCrearRol): ?>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="fas fa-plus-circle text-info me-1"></i> Crear Nuevo Rol</h3>
            </div>
            <div class="card-body p-3">
                <form action="<?php echo URL_ROOT; ?>/perfiles/guardar" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="perfil" class="form-label small fw-bold text-secondary">Nombre del Rango / Rol *</label>
                        <input type="text" name="perfil" id="perfil" class="form-control" placeholder="Ej: colaborador, vip" required>
                        <div class="form-text text-muted small mt-1">El sistema convertirá el nombre automáticamente a minúsculas por consistencia.</div>
                    </div>
                    <button type="submit" class="btn btn-info text-white fw-bold w-100 py-2 shadow-sm">
                        <i class="fas fa-save me-1"></i> Guardar Nuevo Rol
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
