<?php
// /src/Views/socios/create.php
$generos = $generos ?? [];
$paises = $paises ?? [];
$cuotas = $cuotas ?? []; // Recibe las tarifas de la nueva tabla de MariaDB
$error = $error ?? '';

// Verificamos si quien opera la tablet tiene rango de administrador
$esAdminContable = (intval($_SESSION['perfil_id'] ?? 0) === 1) || (intval($_SESSION['permisos']['edit_socios'] ?? 0) === 1);
?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/socios" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0"><i class="fas fa-user-plus text-success me-2"></i>Inscripción de Nuevo Socio</h2>
    </div>
    <div class="card-body p-4 bg-white">

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo URL_ROOT; ?>/socios/guardar" method="POST" autocomplete="off">
            <div class="row g-3">

                <div class="col-12 col-md-6">
                    <label for="nombre" class="form-label small fw-bold text-secondary">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: John" required>
                </div>

                <div class="col-12 col-md-6">
                    <label for="apellidos" class="form-label small fw-bold text-secondary">Apellidos *</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ej: Doe" required>
                </div>

                <div class="col-12 col-md-4">
                    <label for="card_id" class="form-label small fw-bold text-secondary">Documento de Identidad (DNI)</label>
                    <input type="text" name="card_id" id="card_id" class="form-control" placeholder="Ej: 12345678X">
                </div>

                <div class="col-12 col-md-4">
                    <label for="birth" class="form-label small fw-bold text-secondary">Fecha de Nacimiento</label>
                    <input type="date" name="birth" id="birth" class="form-control" required>
                </div>

                <div class="col-12 col-md-4">
                    <label for="genero_id" class="form-label small fw-bold text-secondary">Género</label>
                    <select name="genero_id" id="genero_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($generos as $g): ?>
                            <option value="<?php echo $g['id_genero']; ?>">
                                <?php echo $g['signo'] . ' ' . htmlspecialchars($g['genero'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label for="pais_id" class="form-label small fw-bold text-secondary">Nacionalidad</label>
                    <select name="pais_id" id="pais_id" class="form-select" required>
                        <option value="">Seleccione un país...</option>
                        <?php foreach ($paises as $p): ?>
                            <option value="<?php echo $p['id_pais']; ?>" <?php echo $p['id_pais'] == 1 ? 'selected' : ''; ?>>
                                <?php echo $p['bandera'] . ' ' . htmlspecialchars($p['pais'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- 🌟 ASIGNACIÓN RECURRENTE DE CUOTAS REGULADA POR RANGOS -->
                <div class="col-12 col-md-4">
                    <label for="cuota_id" class="form-label small fw-bold text-secondary">Cuota de Membresía Asignada</label>
                    <?php if ($esAdminContable): ?>
                        <select name="cuota_id" id="cuota_id" class="form-select fw-semibold border-secondary">
                            <?php foreach ($cuotas as $c): ?>
                                <option value="<?php echo $c['id_cuota']; ?>" <?php echo $c['id_cuota'] == 1 ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['nombre_cuota'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo number_format($c['importe'], 2, ',', '.'); ?>€)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <!-- El usuario raso ve la cuota mensual obligatoria fija por defecto -->
                        <select class="form-select bg-light text-muted font-monospace small" disabled>
                            <option selected>Cuota Mensual Estándar (10,00€)</option>
                        </select>
                        <input type="hidden" name="cuota_id" value="1">
                    <?php endif; ?>
                </div>

                <!-- 🌟 INTERRUPTOR EXENTO: Solo modificable por cuentas administrativas -->
                <div class="col-12 col-md-4">
                    <label class="form-label small fw-bold text-secondary d-block">Exención de Cuota</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="exento" id="exento" value="1" <?php echo !$esAdminContable ? 'disabled' : ''; ?>>
                        <label class="form-check-label small fw-semibold text-secondary" for="exento">Marcar como Exento de Pago</label>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="consumo" class="form-label small fw-bold text-secondary">Estimación de Consumo Mensual (Gramos)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="consumo" id="consumo" class="form-control" placeholder="0,00" value="0">
                        <span class="input-group-text bg-light text-muted">g</span>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="saldo" class="form-label small fw-bold text-secondary">Aportación / Saldo Inicial (€)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="saldo" id="saldo" class="form-control font-monospace fw-bold text-success" placeholder="0,00" value="0">
                        <span class="input-group-text bg-light text-muted">€</span>
                    </div>
                </div>

            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?php echo URL_ROOT; ?>/socios" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-success fw-bold px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Registrar Socio
                </button>
            </div>
        </form>
    </div>
</div>