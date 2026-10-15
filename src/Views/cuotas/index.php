<?php
// /src/Views/cuotas/index.php
$cuotas = $cuotas ?? [];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1"><i class="fas fa-hand-holding-usd text-warning me-2"></i>Mantenimiento de Cuotas</h2>
        <p class="text-muted mb-0">Configura y edita los importes de las membresías del club</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo URL_ROOT; ?>/socios" class="btn btn-outline-secondary fw-bold shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver a Socios
        </a>
        <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['crear_cuotas'] ?? 0) === 1): ?>
        <a href="<?php echo URL_ROOT; ?>/cuotas/nuevo" class="btn btn-warning text-dark fw-bold shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nueva Tarifa
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="card-body p-0 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="table-layout: fixed; width: 100%;">
                <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">
                    <tr>
                        <th class="px-4 py-3" style="width: 100px;">ID Tarifa</th>
                        <th class="py-3" style="width: 400px;">Concepto / Modalidad de Membresía</th>
                        <th class="py-3 text-center" style="width: 180px;">Importe Establecido</th>
                        <th class="py-3 text-center" style="width: 140px;">Estado</th>
                        <th class="px-4 py-3 text-center" style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cuotas as $c): ?>
                        <tr class="border-bottom border-light">
                            <td class="px-4 fw-bold text-muted font-monospace">#<?php echo $c['id_cuota']; ?></td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($c['nombre_cuota'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center font-monospace fw-bold text-success" style="font-size: 1.05rem;">
                                <?php echo number_format($c['importe'], 2, ',', '.'); ?> €
                            </td>
                            <td class="text-center">
                                <?php if (intval($c['activo'] ?? 0) === 1): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small">Vigente</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1 small">Suspendida</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 text-center">
                                <a href="<?php echo URL_ROOT; ?>/cuotas/editar?id=<?php echo $c['id_cuota']; ?>" class="btn btn-sm btn-outline-warning text-dark fw-bold w-100 shadow-sm py-1">
                                    <i class="fas fa-edit"></i> Ajustar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
