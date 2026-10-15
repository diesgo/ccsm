<?php $esc = static function ($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); }; ?>
<h1 class="h3">Conversaciones que nos han dejado</h1>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert"><?php echo $esc($error); ?></div>
<?php else: ?>
    <p class="text-muted"><?php echo (int) $bandeja['totales']['total']; ?> mensajes · <?php echo (int) $bandeja['totales']['pendientes']; ?> por leer. Solo administradores reales. No se envían respuestas automáticamente.</p>
    <?php if (!$bandeja['filas']): ?><div class="card card-body">Todavía no hay conversaciones. Los mensajes del formulario aparecerán aquí.</div><?php endif; ?>
    <?php foreach ($bandeja['filas'] as $mensaje): ?>
        <article class="card card-body border-0 shadow-sm mb-3">
            <div class="d-flex flex-wrap justify-content-between gap-2"><h2 class="h5"><?php echo $esc(Contacto::TEMAS[$mensaje['tema']] ?? $mensaje['tema']); ?></h2><span class="badge <?php echo $mensaje['leido'] ? 'bg-secondary' : 'bg-success'; ?>"><?php echo $mensaje['leido'] ? 'Leído' : 'Nuevo'; ?></span></div>
            <p class="small text-muted"><?php echo $esc($mensaje['nombre'] ?: 'Sin nombre'); ?> · <?php echo $esc($mensaje['email']); ?> · <?php echo $esc($mensaje['fecha']); ?></p>
            <p style="white-space: pre-wrap; overflow-wrap: anywhere;"><?php echo $esc($mensaje['mensaje']); ?></p>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-outline-success btn-sm" href="<?php echo $esc('mailto:' . $mensaje['email']); ?>">Responder desde mi correo</a>
                <?php if (!$mensaje['leido']): ?>
                    <form action="<?php echo URL_ROOT; ?>/contacto/leido" method="POST">
                        <input type="hidden" name="csrf" value="<?php echo $esc($_SESSION['contacto_admin_csrf']); ?>">
                        <input type="hidden" name="id" value="<?php echo (int) $mensaje['id']; ?>">
                        <button class="btn btn-outline-secondary btn-sm" type="submit">Marcar como leído</button>
                    </form>
                <?php endif; ?>
            </div>
        </article>
    <?php endforeach; ?>
    <nav class="d-flex justify-content-between gap-2" aria-label="Paginación de mensajes">
        <span>Página <?php echo $bandeja['pagina']; ?> de <?php echo $bandeja['paginas']; ?></span>
        <div>
            <?php if ($bandeja['pagina'] > 1): ?><a class="btn btn-outline-secondary btn-sm" href="<?php echo URL_ROOT; ?>/contacto/bandeja?pagina=<?php echo $bandeja['pagina'] - 1; ?>">Anterior</a><?php endif; ?>
            <?php if ($bandeja['pagina'] < $bandeja['paginas']): ?><a class="btn btn-outline-secondary btn-sm" href="<?php echo URL_ROOT; ?>/contacto/bandeja?pagina=<?php echo $bandeja['pagina'] + 1; ?>">Siguiente</a><?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
