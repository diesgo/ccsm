<?php
// /src/Views/users/create.php
$perfiles = $perfiles ?? [];
?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/usuarios" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado de personal
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0"><i class="fas fa-user-plus text-danger me-2"></i>Dar de Alta Nuevo Empleado / Acceso</h2>
    </div>
    <div class="card-body p-4">

        <!-- Caja de alertas en caso de que el nombre de usuario ya exista -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Formulario que envía los datos por POST a /usuarios/guardar -->
        <form action="<?php echo URL_ROOT; ?>/usuarios/guardar" method="POST" autocomplete="off">
            <div class="row g-3">
                
                <!-- Nombre -->
                <div class="col-12 col-md-6">
                    <label for="nombre" class="form-label small fw-bold text-secondary">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Marcos" required>
                </div>

                <!-- Apellidos -->
                <div class="col-12 col-md-6">
                    <label for="apellidos" class="form-label small fw-bold text-secondary">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ej: García">
                </div>

                <!-- Correo Electrónico -->
                <div class="col-12 col-md-6">
                    <label for="email" class="form-label small fw-bold text-secondary">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="ejemplo@club.com" required>
                </div>

                <!-- Selector de Roles Dinámico -->
                <div class="col-12 col-md-6">
                    <label for="perfil_id" class="form-label small fw-bold text-secondary">Rol / Permisos del Sistema *</label>
                    <select name="perfil_id" id="perfil_id" class="form-select" required>
                        <option value="">Seleccione un rol...</option>
                        <?php foreach ($perfiles as $p): ?>
                            <option value="<?php echo $p['id_perfil']; ?>">
                                <?php echo htmlspecialchars(strtoupper($p['perfil'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Nombre de Usuario para Login -->
                <div class="col-12 col-md-6">
                    <label for="username" class="form-label small fw-bold text-secondary">Nombre de Usuario (Para Login) *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fas fa-at"></i></span>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Ej: marcos_vendedor" required>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="col-12 col-md-6">
                    <label for="password" class="form-label small fw-bold text-secondary">Contraseña de Acceso *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Estado Activo/Inactivo -->
                <div class="col-12">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" checked>
                        <label class="form-check-label small fw-bold text-dark" for="activo">Permitir el acceso inmediato al panel con esta cuenta</label>
                    </div>
                </div>

            </div>

            <!-- Botones de Acción -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?php echo URL_ROOT; ?>/usuarios" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-danger fw-bold px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Registrar Empleado
                </button>
            </div>
        </form>
    </div>
</div>
