<?php
$esc = static function ($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); };
$formulario = $formulario ?? [];
?>
<style>
    .contacto-conversacion { max-width: 800px; margin: 1rem auto; }
    .contacto-saludo { background: #eaf4ed; border-radius: 1.5rem 1.5rem 1.5rem .25rem; }
    .contacto-respuesta { border-radius: 1.5rem 1.5rem .25rem 1.5rem; }
    .contacto-trampa { position: absolute; left: -10000px; }
</style>
<div class="contacto-conversacion">
    <a href="<?php echo URL_ROOT; ?>/login" class="text-success small">Volver al inicio</a>
    <section class="contacto-saludo p-4 mt-3 mb-4">
        <span class="text-success fs-3"><i class="bi bi-chat-heart" aria-hidden="true"></i></span>
        <h1 class="h2 fw-bold mt-2">Sin tickets. Sin discursos.<br>Cuéntanos, te leemos.</h1>
        <p class="mb-0">Una idea a medio hacer, algo que no encaja o un simple «hola». No hace falta escribir una carta perfecta.</p>
    </section>
    <?php if (!empty($enviado)): ?>
        <div class="alert alert-success" role="status"><h2 class="h5">¡Tu mensaje ya está aquí!</h2><p class="mb-0">Gracias por abrir la conversación. Lo hemos guardado en la bandeja privada del equipo. Si hace falta responder, tenemos tu email.</p></div>
        <a href="<?php echo URL_ROOT; ?>/contacto" class="btn btn-outline-success">Tengo algo más que contar</a>
    <?php else: ?>
        <?php if (!empty($error)): ?><div class="alert alert-danger" role="alert"><?php echo $esc($error); ?></div><?php endif; ?>
        <form action="<?php echo URL_ROOT; ?>/contacto" method="POST" class="card contacto-respuesta border-0 shadow-sm p-4">
            <input type="hidden" name="csrf" value="<?php echo $esc($_SESSION['contacto_csrf'] ?? ''); ?>">
            <div class="contacto-trampa" aria-hidden="true"><label>Deja esto vacío<input name="web" tabindex="-1" autocomplete="off"></label></div>
            <fieldset class="mb-4">
                <legend class="h5">Hoy vengo porque…</legend>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach (Contacto::TEMAS as $tema => $etiqueta): ?>
                        <input class="btn-check" type="radio" id="contacto-<?php echo $tema; ?>" name="tema" value="<?php echo $tema; ?>" <?php echo ($formulario['tema'] ?? 'hola') === $tema ? 'checked' : ''; ?> required>
                        <label class="btn btn-outline-success rounded-pill" for="contacto-<?php echo $tema; ?>"><?php echo $etiqueta; ?></label>
                    <?php endforeach; ?>
                </div>
            </fieldset>
            <label for="contacto-mensaje" class="form-label fw-semibold">Te cuento…</label>
            <textarea id="contacto-mensaje" name="mensaje" rows="4" class="form-control mb-1" maxlength="4000" placeholder="Estaba probando GreenPower y se me ocurrió que…" required><?php echo $esc($formulario['mensaje'] ?? ''); ?></textarea>
            <span class="small text-muted mb-4">Con tus palabras, hasta 4000 caracteres. Mejor sin datos personales de terceros ni contraseñas.</span>
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-5"><label for="contacto-nombre" class="form-label">Puedes llamarme… <span class="small text-muted">(opcional)</span></label><input id="contacto-nombre" name="nombre" class="form-control" maxlength="100" autocomplete="name" value="<?php echo $esc($formulario['nombre'] ?? ''); ?>"></div>
                <div class="col-12 col-sm-7"><label for="contacto-email" class="form-label">Si queréis responderme, aquí estoy</label><input id="contacto-email" name="email" type="email" class="form-control" maxlength="254" autocomplete="email" placeholder="tu@email.com" value="<?php echo $esc($formulario['email'] ?? ''); ?>" required></div>
            </div>
            <p class="small text-muted">Este mensaje sí se conserva, junto con tu email, nombre si lo das y fecha de envío, para atender tu consulta. Solo los administradores de esta instalación pueden leerlo. No se publica ni se envía a servicios externos. No forma parte de los datos temporales de la demo.</p>
            <div class="form-check mb-3"><input id="contacto-aviso" class="form-check-input" type="checkbox" name="aviso" value="1" required><label for="contacto-aviso" class="form-check-label small">He leído cómo se guarda mi mensaje.</label></div>
            <button class="btn btn-success py-2 align-self-start" type="submit">Abrir la conversación <i class="bi bi-send ms-1" aria-hidden="true"></i></button>
        </form>
    <?php endif; ?>
</div>
