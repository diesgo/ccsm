<?php $mostrarDemo = Demo::habilitada(); ?>
<style>
    .login-bienvenida { max-width: 1080px; margin: 1rem auto; }
    .login-presentacion { background: #eaf4ed; border-radius: 1.25rem; }
    .login-presentacion h1 { max-width: 650px; letter-spacing: -.04em; }
    .login-paso { display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; flex-shrink: 0; border-radius: 50%; background: #198754; color: white; font-weight: 700; }
    .login-tarjeta { border-radius: 1.25rem; }
    .login-aviso { background: #f1f7f3; border-radius: .75rem; }
</style>
<div class="login-bienvenida">
    <section class="login-presentacion p-4 p-md-5 mb-4" aria-labelledby="login-bienvenida">
        <span class="text-success fw-semibold"><i class="bi bi-leaf me-2" aria-hidden="true"></i>GreenPower CCSM</span>
        <h1 id="login-bienvenida" class="display-6 fw-bold mt-3 mb-3">Tu club, más organizado.<br>Tu día a día, más sencillo.</h1>
        <p class="fs-5 text-secondary mb-4">Socios, dispensario, inventario e informes en un mismo lugar, para que puedas dedicar más tiempo a lo que importa.</p>
        <?php if ($mostrarDemo): ?>
            <p class="mb-3">Conoce GreenPower a tu ritmo. Es una aplicación descargable, pensada para que cualquiera pueda instalarla en su propio hosting y gestionar sus datos allí.</p>
            <div class="row g-3" aria-label="Cómo empezar con GreenPower">
                <?php foreach (['Descarga el paquete', 'Súbelo a tu hosting compatible', 'Ejecuta el instalador y empieza'] as $paso => $texto): ?>
                    <div class="col-12 col-md-4 d-flex align-items-center gap-2">
                        <span class="login-paso"><?php echo $paso + 1; ?></span>
                        <span class="small fw-semibold"><?php echo $texto; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="mb-0">Bienvenido a tu espacio de gestión. Entra con tu cuenta para continuar.</p>
        <?php endif; ?>
    </section>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar aviso"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4 <?php echo !$mostrarDemo ? 'justify-content-center' : ''; ?>">
        <section class="col-12 col-lg-5" aria-labelledby="login-cuenta">
            <div class="card login-tarjeta border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <span class="text-success fs-3"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
                    <h2 id="login-cuenta" class="h4 fw-bold mt-3">Qué bueno verte de nuevo</h2>
                    <p class="text-muted mb-4">Si ya tienes una cuenta en esta instalación, este es tu sitio.</p>
                    <form action="<?php echo URL_ROOT; ?>/login" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Tu nombre de usuario" autocomplete="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" autocomplete="current-password" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success w-100 py-2 fw-semibold">Entrar a mi espacio</button>
                    </form>
                </div>
            </div>
        </section>

        <?php if ($mostrarDemo): ?>
            <section class="col-12 col-lg-7" aria-labelledby="login-demo">
                <div class="card login-tarjeta border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <span class="text-success fs-3"><i class="bi bi-play-circle" aria-hidden="true"></i></span>
                        <h2 id="login-demo" class="h4 fw-bold mt-3">¿Nos conocemos? Prueba la demo</h2>
                        <p class="text-muted">Explora todas las funciones con datos de ejemplo, sin instalar nada y sin miedo a equivocarte. Tendrás tu propio espacio de prueba durante dos horas.</p>
                        <form action="<?php echo URL_ROOT; ?>/demo/entrar" method="POST">
                            <?php if (!isset($_SESSION['demo_entrada_csrf'])) { $_SESSION['demo_entrada_csrf'] = bin2hex(random_bytes(24)); } ?>
                            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['demo_entrada_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-sm-6">
                                    <label for="demo-nombre" class="form-label">¿Cómo te llamas?</label>
                                    <input type="text" id="demo-nombre" name="demo_nombre" class="form-control" maxlength="100" autocomplete="name" value="<?php echo htmlspecialchars($demoNombre ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="demo-email" class="form-label">Tu email</label>
                                    <input type="email" id="demo-email" name="demo_email" class="form-control" maxlength="254" autocomplete="email" value="<?php echo htmlspecialchars($demoEmail ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                            </div>
                            <div class="login-aviso p-3 mb-3">
                                <h3 class="h6 fw-semibold"><i class="bi bi-bar-chart-line me-1" aria-hidden="true"></i>Tu visita nos ayuda a mejorar</h3>
                                <p class="small mb-2"><strong>No conservamos el contenido de tus pruebas.</strong> Los socios que crees, las operaciones, los formularios y las fotos solo existen en tu entorno temporal y se eliminan al salir o caducar. Usa datos ficticios.</p>
                                <p class="small mb-2">Para mejorar la demo sí conservamos tu nombre, email, fechas, secciones visitadas, acciones y resultados, y una estimación de actividad. Este análisis no guarda el contenido de los formularios, pulsaciones, IP ni grabaciones de pantalla.</p>
                                <p class="small text-muted mb-0">Las valoraciones, sugerencias y mensajes de contacto que decidas enviar también se guardan. Solo los administradores de esta instalación pueden consultarlos. No se envía analítica de las instalaciones descargadas a ningún servidor externo.</p>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" id="demo-aviso" name="demo_aviso" value="1" class="form-check-input" required>
                                <label for="demo-aviso" class="form-check-label small">He leído cómo se usan los datos de mi visita.</label>
                            </div>
                            <button type="submit" class="btn btn-outline-success w-100 py-2 fw-semibold"><i class="bi bi-play-circle me-1" aria-hidden="true"></i> Entrar en demo</button>
                            <p class="small text-muted text-center mt-2 mb-0">Sin contraseña. Solo necesitas ganas de explorar.</p>
                        </form>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
    <div class="text-center mt-4">
        <span class="text-muted">¿Una idea, una duda o simplemente un hola?</span>
        <a href="<?php echo URL_ROOT; ?>/contacto" class="btn btn-link text-success fw-semibold">Vamos a hablar <i class="bi bi-chat-heart ms-1" aria-hidden="true"></i></a>
    </div>
    <?php if (isset($_SESSION['demo_salida_id'])): ?>
        <a href="<?php echo URL_ROOT; ?>/demo/salir" class="btn btn-outline-secondary mt-4">Finalizar mi visita y compartir sugerencias</a>
    <?php endif; ?>
</div>
