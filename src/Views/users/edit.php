<?php
// /src/Views/users/edit.php
$u = $usuario ?? [];
$perfiles = $perfiles ?? [];
?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/usuarios" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h2 class="h5 fw-bold text-dark mb-0"><i class="fas fa-user-edit text-danger me-2"></i>Modificar Empleado: <?php echo htmlspecialchars(($u['nombre'] ?? '') . ' ' . ($u['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h2>
        <span class="badge <?php echo ($u['activo'] ?? 0) == 1 ? 'bg-success' : 'bg-secondary'; ?> rounded-pill">
            <?php echo ($u['activo'] ?? 0) == 1 ? 'Acceso Activo' : 'Acceso Bloqueado'; ?>
        </span>
    </div>
    <div class="card-body p-4">

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo URL_ROOT; ?>/usuarios/actualizar" method="POST" autocomplete="off">
            <!-- Campo oculto indispensable con el ID -->
            <input type="hidden" name="id_user" value="<?php echo $u['id_user']; ?>">

            <div class="row g-3">
                <!-- Nombre -->
                <div class="col-12 col-md-6">
                    <label for="nombre" class="form-label small fw-bold text-secondary">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($u['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Apellidos -->
                <div class="col-12 col-md-6">
                    <label for="apellidos" class="form-label small fw-bold text-secondary">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo htmlspecialchars($u['apellidos'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Correo -->
                <div class="col-12 col-md-6">
                    <label for="email" class="form-label small fw-bold text-secondary">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($u['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Rol -->
                <div class="col-12 col-md-6">
                    <label for="perfil_id" class="form-label small fw-bold text-secondary">Rol / Permisos del Sistema *</label>
                    <select name="perfil_id" id="perfil_id" class="form-select" required>
                        <option value="">Seleccione un rol...</option>
                        <?php foreach ($perfiles as $p): ?>
                            <!-- Si el ID del bucle coincide con el perfil asignado en el SQL, agregamos 'selected' -->
                            <option value="<?php echo $p['id_perfil']; ?>" <?php echo (intval($p['id_perfil']) === intval($u['perfil_id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars(strtoupper($p['perfil'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- Nombre de Usuario -->
                <div class="col-12 col-md-6">
                    <label for="username" class="form-label small fw-bold text-secondary">Nombre de Usuario (Login) *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fas fa-at"></i></span>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($u['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>

                <!-- Contraseña Opcional -->
                <div class="col-12 col-md-6">
                    <label for="password" class="form-label small fw-bold text-secondary">Nueva Contraseña (Opcional)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Dejar en blanco para conservar la actual">
                    </div>
                    <div class="form-text text-muted small mt-1">Si no deseas modificar la contraseña actual de este usuario, deja este campo vacío [1].</div>
                </div>

                <!-- Control de Activación -->
                <div class="col-12">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" <?php echo ($u['activo'] ?? 0) == 1 ? 'checked' : ''; ?>>
                        <label class="form-check-label small fw-bold text-dark" for="activo">Cuenta de empleado habilitada para iniciar sesión</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?php echo URL_ROOT; ?>/usuarios" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-danger fw-bold px-4 shadow-sm">
                    <i class="fas fa-sync-alt me-1"></i> Actualizar Personal
                </button>
            </div>
        </form>
    </div>
</div>