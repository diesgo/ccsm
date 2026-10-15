<div class="card border-0 shadow-sm mx-auto" style="max-width: 650px;">
    <div class="card-body p-4">
        <h2 class="h4">Gracias por probar la demo</h2>
        <?php if (!empty($aviso)): ?>
            <div class="alert alert-warning" role="alert"><?php echo htmlspecialchars($aviso, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <p>¿Cómo ha ido? Cuéntanos qué te ha gustado o qué te haría el día a día más fácil. Tus ideas nos ayudan a mejorar GreenPower, pero no hace falta escribir nada para salir.</p>
        <p class="small text-muted"><strong>El contenido de tus pruebas no se conserva.</strong> Al salir eliminamos el entorno temporal y sus fotos. Solo quedan tu registro de uso, las valoraciones y sugerencias que envíes, y los mensajes de contacto enviados expresamente, visibles para los administradores.</p>
        <form method="POST" action="<?php echo URL_ROOT; ?>/demo/salir">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['demo_salida_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
            <fieldset class="mb-3">
                <legend class="h6">¿Te ha resultado fácil? (opcional)</legend>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach (['1' => 'Me costó', '2' => 'Algo difícil', '3' => 'Normal', '4' => 'Fácil', '5' => 'Muy fácil'] as $valor => $etiqueta): ?>
                        <label class="border rounded p-2 small"><input type="radio" name="facilidad" value="<?php echo $valor; ?>" <?php echo (string) ($valoracion['facilidad'] ?? '') === (string) $valor ? 'checked' : ''; ?>> <?php echo $etiqueta; ?></label>
                    <?php endforeach; ?>
                </div>
            </fieldset>
            <fieldset class="mb-3">
                <legend class="h6">¿La instalarías en tu hosting? (opcional)</legend>
                <?php foreach (['si' => 'Sí, me encaja', 'quizas' => 'Quiero pensarlo', 'no' => 'No es para mí'] as $valor => $etiqueta): ?>
                    <label class="me-3 small"><input type="radio" name="instalaria" value="<?php echo $valor; ?>" <?php echo ($valoracion['instalaria'] ?? '') === $valor ? 'checked' : ''; ?>> <?php echo $etiqueta; ?></label>
                <?php endforeach; ?>
            </fieldset>
            <label for="demo-sugerencias" class="form-label">Sugerencias (opcional)</label>
            <textarea id="demo-sugerencias" name="sugerencias" class="form-control mb-3" rows="5" maxlength="4000"><?php echo htmlspecialchars($sugerencias ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            <div class="d-flex flex-wrap gap-2">
                <button type="submit" name="accion" value="enviar" class="btn btn-success">Enviar y salir</button>
                <button type="submit" name="accion" value="omitir" class="btn btn-outline-secondary" formnovalidate>Salir sin enviar</button>
            </div>
        </form>
    </div>
</div>
