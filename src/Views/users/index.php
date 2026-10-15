<?php $usuarios = $usuarios ?? []; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1"><i class="fas fa-user-shield text-danger me-2"></i>Gestión de Personal</h2>
        <p class="text-muted mb-0">Administración de cuentas de acceso al panel (Administradores, Vendedores y Colaboradores)</p>
    </div>
    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['crear_personal'] ?? 0) === 1): ?>
    <a href="<?php echo URL_ROOT; ?>/usuarios/nuevo" class="btn btn-danger fw-bold shadow-sm">
        <i class="fas fa-user-plus me-1"></i> Añadir Empleado
    </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom text-secondary small text-uppercase fw-bold">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="py-3">Nombre Completo</th>
                        <th class="py-3">Usuario (Login)</th>
                        <th class="py-3">Correo Electrónico</th>
                        <th class="py-3">Rol / Perfil</th>
                        <th class="py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center" style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td class="px-4 text-muted fw-bold">#<?php echo $u['id_user']; ?></td>

                            <!-- Corrección para el Nombre Completo (evita nulos en apellidos) -->
                            <td class="fw-bold text-dark">
                                <?php
                                $nombreCompleto = ($u['nombre'] ?? '') . ' ' . ($u['apellidos'] ?? '');
                                echo htmlspecialchars($nombreCompleto, ENT_QUOTES, 'UTF-8');
                                ?>
                            </td>

                            <td><code class="text-danger fw-bold"><?php echo htmlspecialchars($u['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?></code></td>

                            <!-- Corrección para el Correo Electrónico (evita nulos en emails vacíos) -->
                            <td class="small">
                                <?php echo htmlspecialchars($u['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </td>

                            <td>
                                <span class="badge bg-dark-subtle text-dark border rounded-pill px-2.5 py-1 text-uppercase small">
                                    <?php echo htmlspecialchars($u['perfil'] ?? 'Usuario', ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if (($u['activo'] ?? 0) == 1): ?>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-muted rounded-pill px-2 py-0.5">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 text-center">
                                <a href="<?php echo URL_ROOT; ?>/usuarios/editar?id=<?php echo $u['id_user']; ?>"
                                    class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1 fw-bold shadow-sm"
                                    title="Modificar Permisos">
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