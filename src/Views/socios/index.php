<?php
// /src/Views/socios/index.php
// Inicialización de seguridad para el array de socios
$socios = $socios ?? [];
$busqueda = $busqueda ?? '';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1"><i class="fas fa-users text-success me-2"></i>Control de Socios</h2>
        <p class="text-muted mb-0">Listado general de miembros registrados en el club</p>
    </div>
    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['crear_socios'] ?? 0) === 1): ?>
    <a href="<?php echo URL_ROOT; ?>/socios/nuevo" class="btn btn-success fw-bold shadow-sm">
        <i class="fas fa-user-plus me-1"></i> Nuevo Socio
    </a>
    <?php endif; ?>
</div>

<form method="GET" action="<?php echo URL_ROOT; ?>/socios" class="d-flex align-items-center gap-2 mb-3" role="search">
    <div class="input-group input-group-sm" style="max-width: 420px;">
        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
        <input type="search" name="q" class="form-control" placeholder="Buscar por nombre, apellidos, DNI o ID..." value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8'); ?>" autofocus>
        <button type="submit" class="btn btn-success fw-bold">Buscar</button>
    </div>
    <?php if ($busqueda !== ''): ?>
        <a href="<?php echo URL_ROOT; ?>/socios" class="btn btn-sm btn-light border">Quitar filtro</a>
    <?php endif; ?>
    <span class="small text-muted ms-2"><?php echo count($socios); ?> socio(s)</span>
</form>

<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="card-body p-0 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="min-width: 1000px; table-layout: fixed;">
                <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">
                    <tr>
                        <!-- 🌟 DISTRIBUCIÓN HORIZONTAL RIGUROSA SIN MONTAR TEXTOS -->
                        <th class="px-4 py-3" style="width: 75px;">ID</th>
                        <th class="py-3" style="width: 240px;">Socio / Miembro</th>
                        <th class="py-3" style="width: 140px;">Identificación (DNI)</th>
                        <th class="py-3" style="width: 150px;">Nacionalidad</th>
                        <!-- Nueva columna contable integrada -->
                        <th class="py-3" style="width: 170px;">Cuota / Régimen</th>
                        <th class="py-3 text-center" style="width: 120px;">Consumo mensual</th>
                        <th class="py-3 text-end" style="width: 120px;">Saldo disponible</th>
                        <th class="py-3 text-center" style="width: 90px;">Estado</th>
                        <th class="px-4 py-3 text-center" style="width: 130px;">Acciones</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($socios)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open display-6 mb-3 d-block text-secondary opacity-50"></i>
                                <?php echo $busqueda !== '' ? 'Ningún socio coincide con la búsqueda.' : 'No se encontraron socios registrados en el sistema.'; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($socios as $socio): 
                            $esExento = (intval($socio['exento'] ?? 0) === 1);
                        ?>
                            <tr class="border-bottom border-light">
                                <td class="px-4 fw-bold text-muted font-monospace">#<?php echo $socio['id_socio']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center fw-bold me-3 shadow-sm" style="width: 42px; height: 42px; min-width: 42px; overflow: hidden;">
                                            <?php if (!empty($socio['imagen_perfil'])): ?>
                                                <img src="<?php echo htmlspecialchars(Demo::urlImagen('socios', $socio['imagen_perfil']), ENT_QUOTES, 'UTF-8'); ?>"
                                                    alt="<?php echo htmlspecialchars($socio['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                    class="img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%;"
                                                    onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'w-100 h-100 bg-success text-white d-flex align-items-center justify-content-center fw-bold\'><?php echo strtoupper(substr($socio['nombre'] ?? 'S', 0, 1)); ?></div>';">
                                            <?php else: ?>
                                                <div class="w-100 h-100 bg-success text-white d-flex align-items-center justify-content-center fw-bold">
                                                    <?php echo strtoupper(substr($socio['nombre'] ?? 'S', 0, 1)); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-truncate" style="max-width: 170px;">
                                            <span class="fw-bold text-dark d-block mb-0 text-truncate">
                                                <?php echo htmlspecialchars(($socio['nombre'] ?? '') . ' ' . ($socio['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                            <small class="text-muted font-monospace text-xs">
                                                <?php echo $socio['signo'] ?? '•'; ?> <?php echo htmlspecialchars($socio['genero'] ?? 'No especificado', ENT_QUOTES, 'UTF-8'); ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="text-dark fw-semibold font-monospace"><?php echo htmlspecialchars(!empty($socio['card_id']) ? $socio['card_id'] : 'S/D', ENT_QUOTES, 'UTF-8'); ?></code>
                                </td>
                                <td>
                                    <div class="text-truncate">
                                        <span class="me-1"><?php echo $socio['bandera'] ?? '🏳️'; ?></span>
                                        <span class="small text-muted text-truncate"><?php echo htmlspecialchars($socio['pais'] ?? 'Desconocido', ENT_QUOTES, 'UTF-8'); ?></span>
                                    </div>
                                </td>
                                
                                <!-- 🌟 COLUMNA DE CUOTA Y EXENCIÓN CON ACABADO PREMIUM -->
                                <td>
                                    <?php if ($esExento): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded px-2 py-1 fw-bold mb-0.5 d-inline-block" style="font-size: 10px;">
                                            👑 EXENTO DE PAGO
                                        </span>
                                    <?php else: ?>
                                        <div class="text-truncate">
                                            <span class="fw-semibold text-secondary small d-block text-truncate">
                                                <?php echo htmlspecialchars($socio['nombre_cuota'] ?? 'Mensual Estándar', ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                            <small class="text-success fw-bold font-monospace" style="font-size: 11px;">
                                                <?php echo number_format($socio['cuota_importe'] ?? 10.00, 2, ',', '.'); ?> €
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center font-monospace small">
                                    <?php echo number_format($socio['consumo'] ?? 0, 2, ',', '.'); ?> g
                                </td>
                                <td class="text-end fw-bold font-monospace <?php echo ($socio['saldo'] ?? 0) > 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo number_format($socio['saldo'] ?? 0, 2, ',', '.'); ?> €
                                </td>
                                <td class="text-center">
                                    <?php if (intval($socio['activo'] ?? 0) === 1): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1 small">De Baja</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- UNIFICACIÓN DE ACCESO CON CANDADO INTELIGENTE -->
                                <td class="px-3 text-center text-nowrap">
                                    <a href="<?php echo URL_ROOT; ?>/socios/editar?id=<?php echo $socio['id_socio']; ?>"
                                       class="btn btn-sm btn-outline-primary d-inline-flex text-nowrap align-items-center justify-content-center gap-1 fw-bold shadow-sm py-1 px-2"
                                       title="Ver expediente e historial contable">
                                        <i class="fas fa-id-card"></i> Gestionar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
