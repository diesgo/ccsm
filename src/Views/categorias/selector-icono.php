<?php
$iconoSeleccionado = $iconoSeleccionado ?? '';
$iconosDispensario = Categoria::iconosDispensario();
$gruposIconos = [
    'Dispensario' => $iconosDispensario,
    'Generales' => array_diff_key(Categoria::iconosDisponibles(), $iconosDispensario)
];
?>
<fieldset class="mb-3">
    <legend class="form-label small fw-bold text-secondary">Icono de la categoría</legend>
    <?php foreach ($gruposIconos as $nombreGrupo => $iconos): ?>
    <div class="small fw-bold text-secondary mb-2"><?php echo $nombreGrupo; ?></div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <?php foreach ($iconos as $clase => $etiqueta): ?>
            <?php $idIcono = 'categoria-icono-' . ($clase ?: 'ninguno'); ?>
            <input type="radio" class="btn-check" name="icono" id="<?php echo $idIcono; ?>"
                value="<?php echo $clase; ?>" <?php echo $iconoSeleccionado === $clase ? 'checked' : ''; ?>>
            <label class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center gap-1 p-2"
                style="width: 92px; min-height: 72px;" for="<?php echo $idIcono; ?>">
                <i class="bi <?php echo $clase ?: 'bi-slash-circle'; ?> fs-4" aria-hidden="true"></i>
                <span class="small"><?php echo htmlspecialchars($etiqueta, ENT_QUOTES, 'UTF-8'); ?></span>
            </label>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <div class="form-text">Selecciona una representación de Bootstrap Icons. Los iconos del dispensario son símbolos aproximados. No se suben imágenes.</div>
</fieldset>
