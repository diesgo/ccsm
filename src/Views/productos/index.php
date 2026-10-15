<?php
// /src/Views/productos/index.php
// Inicialización de seguridad
$productos = $productos ?? [];
$categorias = $categorias ?? [];
$categoriaFiltro = intval($categoriaFiltro ?? 0);
$errorImagen = $errorImagen ?? null;
?>
<?php if ($errorImagen): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($errorImagen, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1"><i class="fas fa-box-open text-primary me-2"></i>Gestión de Inventario</h2>
        <p class="text-muted mb-0">Catálogo general de productos, comestibles y existencias del dispensario</p>
    </div>
    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['crear_productos'] ?? 0) === 1): ?>
    <a href="<?php echo URL_ROOT; ?>/productos/nuevo" class="btn btn-primary fw-bold shadow-sm">
        <i class="fas fa-plus-circle me-1"></i> Añadir Producto
    </a>
    <?php endif; ?>
</div>

<form method="GET" action="<?php echo URL_ROOT; ?>/productos" class="d-flex align-items-center gap-2 mb-3">
    <label for="filtro-categoria" class="small fw-bold text-secondary mb-0">Categoría:</label>
    <select name="categoria" id="filtro-categoria" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
        <option value="0">Todas</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?php echo intval($cat['id_categoria']); ?>" <?php echo intval($cat['id_categoria']) === $categoriaFiltro ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['categoria'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if ($categoriaFiltro > 0): ?>
        <a href="<?php echo URL_ROOT; ?>/productos" class="btn btn-sm btn-light border">Quitar filtro</a>
    <?php endif; ?>
    <span class="small text-muted ms-2"><?php echo count($productos); ?> producto(s)</span>
</form>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold">
                    <tr>
                        <th class="px-4 py-3" style="width: 80px;">ID</th>
                        <th class="py-3">Producto</th>
                        <th class="py-3">Categoría</th>
                        <th class="py-3">Stock</th>
                        <th class="py-3 text-center">Unidad de Medida</th>
                        <th class="py-3 text-end">PVP (Con IVA)</th>
                        <th class="py-3 text-center">Impuesto Aplicado</th>
                        <th class="py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center" style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-boxes display-6 mb-3 d-block text-secondary"></i>
                                <?php echo $categoriaFiltro > 0 ? 'No hay productos en esta categoría.' : 'No hay productos registrados en el inventario actual.'; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr class="<?php echo $producto['visible'] == 0 ? 'table-light text-muted style="opacity: 0.7;"' : ''; ?>">
                                <td class="px-4 fw-bold text-muted">#<?php echo $producto['id_producto']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!-- Contenedor ajustado a tu nueva distribución local -->
                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px; min-width: 50px; overflow: hidden;">
                                            <?php
                                            $rutaImagen = Demo::urlImagen('productos', $producto['imagen_producto']);
                                            ?>
                                            <img src="<?php echo htmlspecialchars($rutaImagen, ENT_QUOTES, 'UTF-8'); ?>"
                                                alt="<?php echo htmlspecialchars($producto['producto'], ENT_QUOTES, 'UTF-8'); ?>"
                                                class="img-fluid"
                                                style="object-fit: cover; width: 100%; height: 100%;"
                                                onerror="this.onerror=null; this.src='https://placehold.co';">
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block mb-0">
                                                <?php echo htmlspecialchars($producto['producto'], ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- 🌟 REPARACIÓN ATÓMICA DE LA VARIABLE: Sincronizada con el foreach del inventario -->
                                <td>
                                    <?php if (!empty($producto['categoria'])): ?>
                                        <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-bold text-uppercase" style="font-size: 11px;">
                                            <?php echo htmlspecialchars($producto['categoria'], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary text-white px-2.5 py-1.5 fw-bold" style="font-size: 11px;">Sin categoría</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php
                                    $stock = (float) $producto['dispensario'];
                                    $servicioId = intval($producto['servicio_id'] ?? 0);
                                    $unidadStock = $servicioId === 1 ? 'g' : ($servicioId === 2 ? 'ud' : '');
                                    if ($stock <= 0) {
                                        $estadoStock = 'Agotado';
                                        $colorStock = 'danger';
                                        $iconoStock = 'bi-x-circle';
                                    } elseif (!in_array($servicioId, [1, 2], true)) {
                                        $estadoStock = 'Sin medida';
                                        $colorStock = 'secondary';
                                        $iconoStock = 'bi-question-circle';
                                    } elseif ($stock <= ($servicioId === 1 ? 10 : 5)) {
                                        $estadoStock = 'Stock bajo';
                                        $colorStock = 'warning';
                                        $iconoStock = 'bi-exclamation-triangle';
                                    } else {
                                        $estadoStock = 'Disponible';
                                        $colorStock = 'success';
                                        $iconoStock = 'bi-check-circle';
                                    }
                                    ?>
                                    <span class="d-block fw-bold font-monospace text-nowrap mb-1">
                                        <?php echo number_format($stock, 2, ',', '.') . ($unidadStock !== '' ? ' ' . $unidadStock : ''); ?>
                                    </span>
                                    <span class="badge bg-<?php echo $colorStock; ?>-subtle text-<?php echo $colorStock; ?> border border-<?php echo $colorStock; ?>-subtle rounded-pill">
                                        <i class="bi <?php echo $iconoStock; ?> me-1" aria-hidden="true"></i><?php echo $estadoStock; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="small text-muted"><?php echo htmlspecialchars($producto['servicio'] ?? 'No asignada', ENT_QUOTES, 'UTF-8'); ?></span>
                                </td>
                                <td class="text-end fw-bold font-monospace text-dark">
                                    <?php echo number_format($producto['pvp'], 2, ',', '.'); ?> €
                                </td>
                                <td class="text-center font-monospace small text-muted">
                                    <?php echo isset($producto['impuesto_porcentaje']) ? number_format((float) $producto['impuesto_porcentaje'], 0, ',', '.') . '%' : 'No asignado'; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($producto['visible'] == 1): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small">Visible</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2 py-0.5 small">Oculto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 text-center">
                                    <div class="btn-group" role="group" aria-label="Acciones de producto">
                                        <!-- Botón de Editar con estilo Bootstrap claro y borde visible -->
                                        <a href="<?php echo URL_ROOT; ?>/productos/editar?id=<?php echo $producto['id_producto']; ?>"
                                            class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1 fw-bold shadow-sm"
                                            title="Editar Producto">
                                            <i class="fas fa-edit"></i> <span class="d-none d-lg-inline">Editar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>