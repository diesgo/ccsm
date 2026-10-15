<?php
// Inicialización de seguridad para evitar alertas de variables no definidas
if (!isset($content)) {
    $content = '';
}
if (!isset($titulo)) {
    $titulo = 'GreenPower CCSM';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Revisa que las llamadas a los archivos de tu carpeta pública tengan la constante PHP delante: -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/bootstrap-icons.css">
    <!-- Font Awesome (CDN): el resto de vistas usa clases "fas fa-*" que no tenían ninguna librería que las sirviera -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        main {
            flex: 1;
        }

        .navbar-custom {
            background-color: #198754;
            /* Verde esmeralda */
        }
    </style>
</head>

<body>

    <!-- /src/Views/layout/main.php -->
    <style>
        /* Estilos personalizados locales para los efectos hover del menú corporativo */
        .nav-link-custom {
            transition: color 0.2s ease-in-out !important;
        }

        .nav-link-custom:hover {
            color: #ffffff !important;
            /* Pasa de gris atenuado a blanco puro */
        }

        .btn-admin-custom {
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, border-color 0.2s ease-in-out !important;
        }

        .btn-admin-custom:hover {
            background-color: #386f31 !important;
            /* Aclara sutilmente el fondo forestal */
            color: #ffdb6d !important;
            /* Transiciona el ocre hacia un tono crema dorado brillante */
            border-color: #ffc107 !important;
            /* Ilumina el borde ocre perimetral */
        }

        .btn-salir-custom {
            transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out !important;
        }

        .btn-salir-custom:hover {
            background-color: #123626 !important;
            /* Brinda un realce intermedio al botón de apagado */
            border-color: #ffdb6d !important;
        }
    </style>

    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #1b4332; border-bottom: 3px solid #ffc107; padding-top: 6px; padding-bottom: 6px;">
        <div class="container-fluid px-4">

            <!-- Logotipo Principal -->
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 font-monospace text-white" href="<?php echo htmlspecialchars(rtrim(URL_ROOT, '/') . '/', ENT_QUOTES, 'UTF-8'); ?>" style="font-size: 1.25rem;">
                <i class="fas fa-cannabis text-warning"></i> GreenPower
            </a>

            <!-- Botón Hamburguesa Móvil -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenedor Colapsable Saneado por Lógica Dinámica de Roles -->
            <div class="collapse navbar-collapse" id="navbarNav">

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php
                    // El administrador supremo (ID 1) mantiene inmunidad, los demás pasan estrictamente por la aduana de llaves
                    $esAdminSupremo = (intval($_SESSION['user_id'] ?? 0) === 1);
                    ?>

                    <!-- Menú Principal Izquierdo: Guiado al 100% por tu Matriz de Permisos en Plural -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center gap-1 gap-lg-2">
                        
                        <!-- 1. Panel General: Solo para el Administrador Supremo o el Perfil 1 -->
                        <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white-50 px-3 fw-semibold nav-link-custom" href="<?php echo htmlspecialchars(rtrim(URL_ROOT, '/') . '/', ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-chart-pie me-1"></i> Panel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white-50 px-3 fw-semibold nav-link-custom" href="<?php echo URL_ROOT; ?>/informes"><i class="bi bi-bar-chart-line me-1" aria-hidden="true"></i> Informes</a>
                            </li>
                        <?php endif; ?>

                        <!-- 2. El Dispensario TPV: Oculto para compras (Perfil 5), visible si tiene ver_socios o ver_productos -->
                        <?php if (intval($_SESSION['perfil_id'] ?? 0) !== 5): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white-50 px-3 fw-semibold nav-link-custom" href="<?php echo URL_ROOT; ?>/dispensario"><i class="fas fa-cash-register me-1"></i> Dispensario</a>
                            </li>
                        <?php endif; ?>

                        <!-- 3. Acceso Directo al Listado de Socios (Visible para Ventas, Caja y Admin) -->
                        <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['ver_socios'] ?? 0) === 1): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white-50 px-3 fw-semibold nav-link-custom" href="<?php echo URL_ROOT; ?>/socios"><i class="fas fa-users me-1"></i> Socios y Miembros</a>
                            </li>
                        <?php endif; ?>

                        <!-- 🌟 4. DESPLEGABLE DE ADMINISTRACIÓN ADAPTATIVO POR LLAVES SQL -->
                        <?php if (
                            intval($_SESSION['perfil_id'] ?? 0) === 1 || 
                            intval($_SESSION['permisos']['ver_proveedores'] ?? 0) === 1 || 
                            intval($_SESSION['permisos']['ver_categorias'] ?? 0) === 1 || 
                            intval($_SESSION['permisos']['ver_productos'] ?? 0) === 1 ||
                            intval($_SESSION['permisos']['ver_cuotas'] ?? 0) === 1
                        ): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-bold d-flex align-items-center gap-1 py-2 px-3" href="#" id="navbarAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ffc107 !important;">
                                    <i class="bi bi-gear-fill text-warning"></i> Administración
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarAdmin">
                                    
                                    <!-- Accesos Granulares del Catálogo Mapeados con tu Base de Datos -->
                                    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['ver_proveedores'] ?? 0) === 1): ?>
                                        <li><a class="dropdown-item fw-semibold text-dark" href="<?php echo URL_ROOT; ?>/proveedores"><i class="fas fa-truck text-muted me-2"></i> Proveedores</a></li>
                                    <?php endif; ?>

                                    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['ver_categorias'] ?? 0) === 1): ?>
                                        <li><a class="dropdown-item fw-semibold text-dark" href="<?php echo URL_ROOT; ?>/categorias"><i class="fas fa-th-list text-muted me-2"></i> Categorías</a></li>
                                    <?php endif; ?>

                                    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['ver_productos'] ?? 0) === 1): ?>
                                        <li><a class="dropdown-item fw-semibold text-dark" href="<?php echo URL_ROOT; ?>/productos"><i class="fas fa-boxes text-muted me-2"></i> Productos e Inventario</a></li>
                                    <?php endif; ?>

                                    <!-- Acceso Directo al Mantenimiento de Tarifas, guiado por su propia llave RBAC (ver_cuotas) -->
                                    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['permisos']['ver_cuotas'] ?? 0) === 1): ?>
                                        <li><a class="dropdown-item fw-bold text-warning-custom text-dark" href="<?php echo URL_ROOT; ?>/cuotas"><i class="fas fa-hand-holding-usd text-muted me-2"></i> Configurar Cuotas</a></li>
                                    <?php endif; ?>

                                    <!-- Logística de Entradas y Suministro (Oculto para mostrador raso) -->
                                    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1 || intval($_SESSION['perfil_id'] ?? 0) === 5): ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-header text-uppercase small fw-bold text-success" style="font-size: 9px; letter-spacing: 0.5px;">Control de Almacén</li>
                                        <li><a class="dropdown-item fw-bold text-dark" href="<?php echo URL_ROOT; ?>/compras"><i class="bi bi-boxes text-success me-2"></i> Histórico de Compras</a></li>
                                        <li><a class="dropdown-item fw-bold text-dark" href="<?php echo URL_ROOT; ?>/compras/crear"><i class="bi bi-file-earmark-plus-fill text-primary me-2"></i> Registrar Albarán</a></li>
                                    <?php endif; ?>

                                    <!-- Bloque Crítico: Restringido estrictamente al Administrador del local -->
                                    <?php if (intval($_SESSION['perfil_id'] ?? 0) === 1): ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <?php if (!Demo::activa()): ?>
                                            <li><a class="dropdown-item fw-semibold" href="<?php echo URL_ROOT; ?>/contacto/bandeja"><i class="bi bi-envelope me-2" aria-hidden="true"></i> Mensajes de contacto</a></li>
                                        <?php endif; ?>
                                        <li class="dropdown-header text-uppercase small fw-bold text-danger" style="font-size: 9px; letter-spacing: 0.5px;">Configuración Crítica</li>
                                        <li><a class="dropdown-item fw-semibold text-danger" href="<?php echo URL_ROOT; ?>/personal"><i class="fas fa-user-shield me-2"></i> Personal y Usuarios</a></li>
                                        <li><a class="dropdown-item fw-semibold text-danger" href="<?php echo URL_ROOT; ?>/roles"><i class="fas fa-user-tag me-2"></i> Roles y Permisos</a></li>
                                        <li><a class="dropdown-item fw-semibold text-danger" href="<?php echo URL_ROOT; ?>/configuracion"><i class="fas fa-sliders-h me-2"></i> Opciones del Sistema</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>


                    <!-- BOTÓN SALIR (Se queda igual) -->
                    <div class="d-flex align-items-center mt-2 mt-lg-0">
                        <a class="btn d-flex align-items-center gap-2 fw-bold px-3 py-1.5 shadow btn-salir-custom"
                            href="<?php echo URL_ROOT; ?>/logout"
                            style="background-color: #0b251a; color: #ffc107; border: 1px solid #ffc107; border-radius: 6px;">
                            <i class="fas fa-sign-out-alt"></i> Salir (<span style="color: #ffffff;"><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></span>)
                        </a>
                    </div>
                <?php else: ?>
                    <div class="d-flex align-items-center ms-auto">
                        <a class="btn btn-sm btn-outline-light fw-semibold px-3 py-2" href="<?php echo URL_ROOT; ?>/login">
                            <i class="bi bi-person me-1" aria-hidden="true"></i> Iniciar sesión
                        </a>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </nav>

    <!-- 2. CONTENIDO PRINCIPAL DINÁMICO -->
    <main class="container py-4">
        <?php if (Demo::activa()): ?>
            <div class="alert alert-warning d-flex flex-wrap align-items-center justify-content-between gap-2" role="status">
                <span><strong>Modo demo</strong> — Tus formularios, operaciones y fotos de prueba no se conservan: se eliminan al salir o caducar. Solo guardamos el registro de uso y lo que envíes expresamente como sugerencias o contacto.</span>
                <a href="<?php echo URL_ROOT; ?>/logout" class="btn btn-sm btn-outline-dark">Salir de la demo</a>
            </div>
        <?php endif; ?>
        <?php echo $content; ?>
        <?php if (Demo::activa() && !empty($_SESSION['demo']['registro_id'])): ?>
            <?php
            if (!isset($_SESSION['demo_actividad_csrf'])) {
                $_SESSION['demo_actividad_csrf'] = bin2hex(random_bytes(24));
                $_SESSION['demo_actividad_tiempo'] = time();
            }
            ?>
            <p id="demo-actividad" class="small text-muted d-none" role="status" data-url="<?php echo URL_ROOT; ?>/demo/actividad" data-csrf="<?php echo htmlspecialchars($_SESSION['demo_actividad_csrf'], ENT_QUOTES, 'UTF-8'); ?>"></p>
            <script src="<?php echo URL_ROOT; ?>/js/demo-actividad.js"></script>
        <?php endif; ?>
    </main>

    <!-- 3. PIE DE PÁGINA -->
    <footer class="bg-dark text-secondary py-3 text-center border-top border-secondary">
        <div class="container">
            <small>&copy; <?php echo date('Y'); ?> GreenPower CCSM - 100% Local.</small>
            <a href="<?php echo URL_ROOT; ?>/contacto" class="text-light d-block small mt-1">¿Hablamos?</a>
        </div>
    </footer>

    <!-- Bootstrap 5 JS desde el servidor LOCAL -->
    <!-- Al pie de la página, haz exactamente lo mismo con los scripts de JavaScript: -->
    <script src="<?php echo URL_ROOT; ?>/js/bootstrap.bundle.min.js"></script>
</body>

</html>