<?php
$categorias = $categorias ?? [];
$formulario = $formulario ?? ['categoria' => '', 'activo' => 1, 'servicio_id' => 2, 'icono' => ''];
$puedeCrearCategoria = (intval($_SESSION['perfil_id'] ?? 0) === 1) || (intval($_SESSION['permisos']['crear_categorias'] ?? 0) === 1);
?>
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1"><i class="fas fa-tags text-primary me-2"></i>Categorías del Catálogo</h2>
    <p class="text-muted mb-0">Gestión de las agrupaciones del dispensario (Bebidas, Comestibles, etc.)</p>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>
<div class="row g-4">
    <!-- Tabla de Categorías Existentes -->
    <div class="col-12 <?php echo $puedeCrearCategoria ? 'col-md-8' : ''; ?>">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="px-4 py-3" style="width: 100px;">ID</th>
                                <th class="py-3">Categoría</th>
                                <th class="py-3 text-center" style="width: 150px;">Estado</th>
                                <th class="px-4 py-3 text-center" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $c): ?>
                                <tr>
                                    <td class="px-4 text-muted fw-bold">#<?php echo $c['id_categoria']; ?></td>
                                    <td class="fw-bold text-dark">
                                        <?php if (!empty($c['icono'])): ?>
                                            <i class="bi <?php echo htmlspecialchars($c['icono'], ENT_QUOTES, 'UTF-8'); ?> me-2" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($c['categoria'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (($c['activo'] ?? 0) == 1): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small">Habilitada</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle rounded-pill px-2.5 py-1 small">Deshabilitada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 text-center">
                                        <a href="<?php echo URL_ROOT; ?>/categorias/editar?id=<?php echo $c['id_categoria']; ?>"
                                            class="btn btn-sm btn-outline-warning text-dark fw-bold shadow-sm d-inline-flex align-items-center gap-1" title="Editar Categoría">
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
    <?php if ($puedeCrearCategoria): ?>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="fas fa-plus-circle text-primary me-1"></i> Nueva Categoría</h3>
            </div>
            <div class="card-body p-3">
                <form action="<?php echo URL_ROOT; ?>/categorias/guardar" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="categoria" class="form-label small fw-bold text-secondary">Nombre de la Categoría *</label>
                        <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Ej: Comestibles, Parafernalia" value="<?php echo htmlspecialchars($formulario['categoria'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="activo" id="activo" <?php echo $formulario['activo'] ? 'checked' : ''; ?> value="1">
                            <label class="form-check-label small fw-bold text-dark" for="activo">Habilitar visibilidad en productos</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="servicio_id" class="form-label small fw-bold text-secondary">Despacho Predeterminado *</label>
                        <select name="servicio_id" id="servicio_id" class="form-select" required>
                            <option value="2" <?php echo intval($formulario['servicio_id']) === 2 ? 'selected' : ''; ?>>Por Unidades fijas (ud)</option>
                            <option value="1" <?php echo intval($formulario['servicio_id']) === 1 ? 'selected' : ''; ?>>Al Peso / Granel (g)</option>
                        </select>
                    </div>
                    <?php
                    $iconoSeleccionado = $formulario['icono'];
                    include __DIR__ . '/selector-icono.php';
                    ?>
                    <button type="submit" class="btn btn-primary fw-bold w-100 py-2 shadow-sm">
                        <i class="fas fa-save me-1"></i> Guardar Categoría
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>