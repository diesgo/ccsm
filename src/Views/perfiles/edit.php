<?php
// /src/Views/perfiles/edit.php
$p = $perfil ?? [];
// 🌟 REGLA DE ORO DE SEGURIDAD: Determinamos si el rol en edición es el del Administrador Supremo
$esAdminMaestro = (intval($p['id_perfil'] ?? 0) === 1);
?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/perfiles" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0">
            <i class="fas fa-user-shield text-warning me-2"></i>Configuración de Privilegios del Rol: <?php echo htmlspecialchars(strtoupper($p['perfil'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
        </h2>
    </div>
    <div class="card-body p-4 bg-white">

        <form action="<?php echo URL_ROOT; ?>/perfiles/actualizar" method="POST" autocomplete="off">
            <!-- ID oculto indispensable para la actualización relacional -->
            <input type="hidden" name="id_perfil" value="<?php echo $p['id_perfil']; ?>">

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-5">
                    <label for="perfil" class="form-label small fw-bold text-secondary">Nombre del Rol / Rango *</label>
                    <input type="text" name="perfil" id="perfil" class="form-control text-uppercase fw-bold <?php echo $esAdminMaestro ? 'bg-light text-muted' : ''; ?>" value="<?php echo htmlspecialchars($p['perfil'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required <?php echo $esAdminMaestro ? 'readonly' : ''; ?>>
                </div>
            </div>

            <!-- MATRIZ DE PERMISOS EN FORMATO TABLA PROFESIONAL -->
            <div class="table-responsive border rounded-3 mb-4 shadow-sm bg-white">
                <table class="table table-hover align-middle mb-0" style="min-width: 980px; table-layout: fixed;">
                    <thead class="table-light text-secondary small text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">
                        <tr>
                            <th class="px-4 py-3" style="width: 220px;">Área / Módulo del Sistema</th>
                            <th class="py-3" style="width: 370px;">Descripción de Competencias</th>
                            <th class="py-3 text-center" style="width: 130px;">Ver</th>
                            <th class="py-3 text-center" style="width: 130px;">Crear</th>
                            <th class="px-4 py-3 text-center" style="width: 130px;">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modulosMatriz = [
                            'socios'      => ['label' => '👥 Módulo de Socios', 'desc' => 'Fichas de inscripción, control de cuotas y saldos de monederos.'],
                            'productos'   => ['label' => '📦 Módulo de Productos', 'desc' => 'Catálogo general de artículos, asignación de PVP y existencias.'],
                            'variedades'  => ['label' => '🌿 Módulo de Variedades', 'desc' => 'Clasificaciones botánicas y tipos comerciales.'],
                            'categorias'  => ['label' => '🗂️ Módulo de Categorías', 'desc' => 'Familias de inventario, visibilidad y unidades de medida.'],
                            'proveedores' => ['label' => '🚚 Módulo de Proveedores', 'desc' => 'Empresas distribuidoras, contactos y registro de compras.'],
                            'personal'    => ['label' => '🔒 Módulo de Personal', 'desc' => 'Alta de cuentas de empleados, operarios y credenciales.'],
                            'roles'       => ['label' => '🛠️ Módulo de Roles', 'desc' => 'Matriz de privilegios de seguridad y accesos granulares RBAC.'],
                            'cuotas'      => ['label' => '💳 Módulo de Cuotas', 'desc' => 'Tarifas de socio, importes y mantenimiento de cuotas del club.']
                        ];

                        foreach ($modulosMatriz as $key => $data):
                            $verActivo   = intval($p["ver_{$key}"] ?? 0) === 1;
                            $crearActivo = intval($p["crear_{$key}"] ?? 0) === 1;
                            $editActivo  = intval($p["edit_{$key}"] ?? 0) === 1;
                        ?>
                            <tr class="border-bottom border-light">
                                <td class="px-4 fw-bold text-dark small text-truncate"><?php echo $data['label']; ?></td>
                                <td class="text-muted small"><?php echo $data['desc']; ?></td>

                                <!-- Interruptor Ver -->
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block mb-0">
                                        <input class="form-check-input check-ver" type="checkbox" name="ver_<?php echo $key; ?>" id="ver_<?php echo $key; ?>" value="1"
                                            <?php echo $verActivo ? 'checked' : ''; ?> <?php echo $esAdminMaestro ? 'disabled' : ''; ?> data-modulo="<?php echo $key; ?>">
                                        <label class="form-check-label small fw-semibold text-secondary" for="ver_<?php echo $key; ?>">Ver</label>
                                    </div>
                                </td>

                                <!-- Interruptor Crear -->
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block mb-0">
                                        <input class="form-check-input check-crear" type="checkbox" name="crear_<?php echo $key; ?>" id="crear_<?php echo $key; ?>" value="1"
                                            <?php echo $crearActivo ? 'checked' : ''; ?> <?php echo $esAdminMaestro ? 'disabled' : ''; ?> data-modulo="<?php echo $key; ?>">
                                        <label class="form-check-label small fw-semibold text-primary" for="crear_<?php echo $key; ?>">Crear</label>
                                    </div>
                                </td>

                                <!-- Interruptor Editar -->
                                <td class="px-4 text-center">
                                    <div class="form-check form-switch d-inline-block mb-0">
                                        <input class="form-check-input check-edit" type="checkbox" name="edit_<?php echo $key; ?>" id="edit_<?php echo $key; ?>" value="1"
                                            <?php echo $editActivo ? 'checked' : ''; ?> <?php echo $esAdminMaestro ? 'disabled' : ''; ?> data-modulo="<?php echo $key; ?>">
                                        <label class="form-check-label small fw-semibold text-success" for="edit_<?php echo $key; ?>">Editar</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- BOTONERA DE ACCIÓN PROTEGIDA -->
            <div class="pt-3 border-top d-flex gap-2">
                <a href="<?php echo URL_ROOT; ?>/perfiles" class="btn btn-light border fw-bold px-4">Cancelar</a>

                <?php if ($esAdminMaestro): ?>
                    <!-- 🔒 Bloqueo visual e interactivo total si es el Administrador Supremo -->
                    <button type="button" class="btn btn-secondary fw-bold px-4 shadow-sm" disabled title="Los privilegios del Administrador Supremo están protegidos por el núcleo y no pueden ser alterados.">
                        <i class="fas fa-lock text-warning me-1"></i> Rol Protegido
                    </button>
                <?php else: ?>
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                        <i class="fas fa-sync-alt me-1"></i> Guardar Matriz de Permisos
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- CAPA DE COMPORTAMIENTO INTERACTIVO SANEADA -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Marcar "Crear" o "Editar" activa automáticamente "Ver" (no tiene sentido crear/editar algo que no se puede ver)
        document.querySelectorAll('.check-crear, .check-edit').forEach(sw => {
            sw.addEventListener('change', function() {
                if (this.checked) {
                    const modulo = this.getAttribute('data-modulo');
                    const switchVer = document.getElementById('ver_' + modulo);
                    if (switchVer) switchVer.checked = true;
                }
            });
        });

        // Desmarcar "Ver" apaga en cascada "Crear" y "Editar" de ese mismo módulo
        document.querySelectorAll('.check-ver').forEach(sw => {
            sw.addEventListener('change', function() {
                if (!this.checked) {
                    const modulo = this.getAttribute('data-modulo');
                    const switchCrear = document.getElementById('crear_' + modulo);
                    const switchEdit = document.getElementById('edit_' + modulo);
                    if (switchCrear) switchCrear.checked = false;
                    if (switchEdit) switchEdit.checked = false;
                }
            });
        });
    });
</script>