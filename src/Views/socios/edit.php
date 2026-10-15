<?php
// /src/Views/socios/edit.php
$s = $socio ?? [];
$generos = $generos ?? [];
$paises = $paises ?? [];
$cuotas = $cuotas ?? [];
$errorActualizacion = $errorActualizacion ?? null;
$esAdminContable = (intval($_SESSION['perfil_id'] ?? 0) === 1) || (intval($_SESSION['permisos']['edit_socios'] ?? 0) === 1);

// Rutas de las 3 fotografías, con imagen de respaldo cuando aún no existen
$fotoPerfil   = Demo::urlImagen('socios', ($s['imagen_perfil'] ?? '') ?: 'default.png');
$fotoAnverso  = !empty($s['idFront']) ? Demo::urlImagen('socios', $s['idFront']) : null;
$fotoReverso  = !empty($s['idBack']) ? Demo::urlImagen('socios', $s['idBack']) : null;

$nombreCompleto = trim(($s['nombre'] ?? '') . ' ' . ($s['apellidos'] ?? ''));
$iniciales = '';
foreach (array_filter([$s['nombre'] ?? '', $s['apellidos'] ?? '']) as $palabra) {
    $iniciales .= mb_strtoupper(mb_substr(trim($palabra), 0, 1));
}
?>
<style>
    .ficha-banner {
        background: linear-gradient(120deg, #1e7e34 0%, #28a745 55%, #4caf50 100%);
        border-radius: .75rem .75rem 0 0;
        height: 105px;
        position: relative;
    }
    .ficha-avatar-wrap {
        width: 128px;
        height: 128px;
        margin-top: -64px;
        position: relative;
        z-index: 2;
    }
    .ficha-avatar-wrap img,
    .ficha-avatar-wrap .avatar-iniciales {
        width: 128px;
        height: 128px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        background: #e9ecef;
        box-shadow: 0 2px 10px rgba(0,0,0,.15);
    }
    .avatar-iniciales {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 700;
        color: #6c757d;
    }
    .ficha-avatar-edit {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #198754;
        border: 3px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        cursor: pointer;
        z-index: 3;
        transition: background .15s ease-in-out;
    }
    .ficha-avatar-edit:hover { background: #146c43; }
    .ficha-avatar-edit.disabled { opacity: .45; pointer-events: none; }

    .doc-thumb {
        border: 1px solid #dee2e6;
        border-radius: .6rem;
        background: #f8f9fa center/cover no-repeat;
        height: 110px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .doc-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .doc-thumb .doc-placeholder { color: #adb5bd; text-align: center; font-size: .75rem; cursor: default; }
    .doc-thumb .doc-placeholder.doc-btn-cambiar { cursor: pointer; }
    .doc-thumb .doc-placeholder.doc-btn-cambiar:hover { color: #198754; }
    .doc-thumb .doc-edit-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,.45);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        font-size: .72rem;
        font-weight: 600;
        opacity: 0;
        transition: opacity .15s ease-in-out;
    }
    .doc-thumb:hover .doc-edit-overlay { opacity: 1; }
    .stat-pill {
        border: 1px solid #eee;
        border-radius: .6rem;
        padding: .55rem .75rem;
        background: #fff;
    }
</style>

<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/socios" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="bi bi-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<?php if ($errorActualizacion): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($errorActualizacion, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>

<form action="<?php echo URL_ROOT; ?>/socios/actualizar" method="POST" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_socio" value="<?php echo $s['id_socio']; ?>">

<div class="card shadow-sm border-0 rounded-3 mb-4 overflow-hidden">

    <!-- CABECERA DE PERFIL -->
    <div class="ficha-banner px-4">
        <span class="badge <?php echo intval($s['activo'] ?? 0) === 1 ? 'bg-white text-success' : 'bg-danger'; ?> rounded-pill fw-bold position-absolute" style="top: 14px; right: 18px;">
            <?php echo intval($s['activo'] ?? 0) === 1 ? '● Activo' : '● De Baja'; ?>
        </span>
    </div>

    <div class="px-4 pb-4 bg-white">
        <div class="d-flex flex-column flex-sm-row align-items-sm-end gap-3">
            <!-- Avatar grande con overlay para cambiar la foto -->
            <div class="ficha-avatar-wrap">
                <?php if (!empty($s['imagen_perfil'])): ?>
                    <img id="previewPerfil" src="<?php echo htmlspecialchars($fotoPerfil, ENT_QUOTES, 'UTF-8'); ?>" data-bs-toggle="modal" data-bs-target="#modalFotoPerfil" role="button" title="Ver foto ampliada">
                <?php else: ?>
                    <div id="previewPerfil" class="avatar-iniciales"><?php echo $iniciales ?: '?'; ?></div>
                <?php endif; ?>

                <label for="imagen_perfil" class="ficha-avatar-edit <?php echo !$esAdminContable ? 'disabled' : ''; ?>" title="Cambiar foto de perfil">
                    <i class="bi bi-camera-fill"></i>
                </label>
                <input type="file" name="imagen_perfil" id="imagen_perfil" accept="image/*" class="d-none" <?php echo !$esAdminContable ? 'disabled' : ''; ?>>
            </div>

            <div class="flex-grow-1 pb-1">
                <h2 class="h4 fw-bold text-dark mb-0"><?php echo htmlspecialchars($nombreCompleto ?: 'Socio sin nombre', ENT_QUOTES, 'UTF-8'); ?></h2>
                <div class="text-muted small">
                    <i class="bi bi-credit-card-2-front me-1"></i><?php echo htmlspecialchars($s['card_id'] ?? 'Sin DNI/NIE registrado', ENT_QUOTES, 'UTF-8'); ?>
                    <span class="mx-2">·</span>
                    <i class="bi bi-hash"></i>Socio #<?php echo intval($s['id_socio']); ?>
                </div>
            </div>

            <!-- Mini estadísticas rápidas -->
            <div class="d-flex gap-2 flex-wrap pb-1">
                <div class="stat-pill text-center">
                    <div class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: .5px;">Saldo</div>
                    <div class="fw-bold text-success font-monospace"><?php echo number_format($s['saldo'] ?? 0, 2, ',', '.'); ?> €</div>
                </div>
                <div class="stat-pill text-center">
                    <div class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: .5px;">Consumo</div>
                    <div class="fw-bold text-dark font-monospace"><?php echo number_format($s['consumo'] ?? 0, 2, ',', '.'); ?> g</div>
                </div>
                <div class="stat-pill text-center">
                    <div class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: .5px;">Cuota</div>
                    <div class="fw-bold text-dark"><?php echo intval($s['exento'] ?? 0) === 1 ? 'Exento' : htmlspecialchars(($s['nombre_cuota'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    <!-- COLUMNA IZQUIERDA: DOCUMENTACIÓN -->
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="bi bi-folder2-open text-success me-2"></i>Documentación</h3>
            </div>
            <div class="card-body p-4">

                <!-- Anverso -->
                <label class="form-label small fw-bold text-secondary d-block mb-1">Identificación (Anverso)</label>
                <div class="doc-thumb mb-3" id="thumb_idFront" data-campo="idFront" data-titulo="Identificación · Anverso" style="<?php echo $fotoAnverso ? "background-image:url('" . htmlspecialchars($fotoAnverso, ENT_QUOTES, 'UTF-8') . "');" : ''; ?>">
                    <?php if ($fotoAnverso): ?>
                        <span class="doc-edit-overlay">
                            <button type="button" class="btn btn-sm btn-light doc-btn-ver" title="Ver ampliado"><i class="bi bi-eye-fill"></i></button>
                            <?php if ($esAdminContable): ?>
                                <button type="button" class="btn btn-sm btn-light doc-btn-cambiar" title="Sustituir documento"><i class="bi bi-pencil-fill"></i></button>
                            <?php endif; ?>
                        </span>
                    <?php else: ?>
                        <span class="doc-placeholder <?php echo $esAdminContable ? 'doc-btn-cambiar' : ''; ?>" role="<?php echo $esAdminContable ? 'button' : ''; ?>"><i class="bi bi-file-earmark-plus fs-3 d-block mb-1"></i>Sin documento<br>subido</span>
                    <?php endif; ?>
                </div>
                <input type="file" name="idFront" id="idFront" accept="image/*" class="d-none" <?php echo !$esAdminContable ? 'disabled' : ''; ?>>

                <!-- Reverso -->
                <label class="form-label small fw-bold text-secondary d-block mb-1">Identificación (Reverso)</label>
                <div class="doc-thumb mb-2" id="thumb_idBack" data-campo="idBack" data-titulo="Identificación · Reverso" style="<?php echo $fotoReverso ? "background-image:url('" . htmlspecialchars($fotoReverso, ENT_QUOTES, 'UTF-8') . "');" : ''; ?>">
                    <?php if ($fotoReverso): ?>
                        <span class="doc-edit-overlay">
                            <button type="button" class="btn btn-sm btn-light doc-btn-ver" title="Ver ampliado"><i class="bi bi-eye-fill"></i></button>
                            <?php if ($esAdminContable): ?>
                                <button type="button" class="btn btn-sm btn-light doc-btn-cambiar" title="Sustituir documento"><i class="bi bi-pencil-fill"></i></button>
                            <?php endif; ?>
                        </span>
                    <?php else: ?>
                        <span class="doc-placeholder <?php echo $esAdminContable ? 'doc-btn-cambiar' : ''; ?>" role="<?php echo $esAdminContable ? 'button' : ''; ?>"><i class="bi bi-file-earmark-plus fs-3 d-block mb-1"></i>Sin documento<br>subido</span>
                    <?php endif; ?>
                </div>
                <input type="file" name="idBack" id="idBack" accept="image/*" class="d-none" <?php echo !$esAdminContable ? 'disabled' : ''; ?>>

                <?php if (!$esAdminContable): ?>
                    <p class="text-muted small mb-0 mt-2"><i class="bi bi-lock-fill me-1"></i>Solo la administración puede sustituir documentos.</p>
                <?php else: ?>
                    <p class="text-muted small mb-0 mt-2"><i class="bi bi-info-circle me-1"></i>Haz clic en una imagen para verla en grande o subir una nueva.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- COLUMNA DERECHA: DATOS DEL FORMULARIO -->
    <div class="col-12 col-lg-8">

        <!-- Datos personales -->
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="bi bi-person-vcard text-success me-2"></i>Datos Personales</h3>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="nombre" class="form-label small fw-bold text-secondary">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($s['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required <?php echo !$esAdminContable ? 'readonly' : ''; ?>>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="apellidos" class="form-label small fw-bold text-secondary">Apellidos *</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo htmlspecialchars($s['apellidos'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required <?php echo !$esAdminContable ? 'readonly' : ''; ?>>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="card_id" class="form-label small fw-bold text-secondary">Documento de Identidad (DNI/NIE)</label>
                        <input type="text" name="card_id" id="card_id" class="form-control fw-bold" value="<?php echo htmlspecialchars($s['card_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" <?php echo !$esAdminContable ? 'readonly' : ''; ?>>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="birth" class="form-label small fw-bold text-secondary">Fecha de Nacimiento</label>
                        <input type="date" name="birth" id="birth" class="form-control" value="<?php echo $s['birth'] ?? ''; ?>" required <?php echo !$esAdminContable ? 'readonly' : ''; ?>>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="genero_id" class="form-label small fw-bold text-secondary">Género</label>
                        <select name="genero_id" id="genero_id" class="form-select" <?php echo !$esAdminContable ? 'disabled' : ''; ?>>
                            <?php foreach ($generos as $g): ?>
                                <option value="<?php echo $g['id_genero']; ?>" <?php echo intval($g['id_genero']) === intval($s['genero_id'] ?? 0) ? 'selected' : ''; ?>>
                                    <?php echo $g['signo'] . ' ' . htmlspecialchars($g['genero'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="pais_id" class="form-label small fw-bold text-secondary">Nacionalidad</label>
                        <select name="pais_id" id="pais_id" class="form-select" <?php echo !$esAdminContable ? 'disabled' : ''; ?>>
                            <?php foreach ($paises as $p): ?>
                                <option value="<?php echo $p['id_pais']; ?>" <?php echo intval($p['id_pais']) === intval($s['pais_id'] ?? 0) ? 'selected' : ''; ?>>
                                    <?php echo $p['bandera'] . ' ' . htmlspecialchars($p['pais'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="cuota_id" class="form-label small fw-bold text-secondary">Cuota Regular Asignada</label>
                        <select name="cuota_id" id="cuota_id" class="form-select fw-semibold text-dark" <?php echo !$esAdminContable ? 'disabled' : ''; ?>>
                            <?php foreach ($cuotas as $c): ?>
                                <option value="<?php echo $c['id_cuota']; ?>" <?php echo intval($c['id_cuota']) === intval($s['cuota_id'] ?? 1) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['nombre_cuota'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo number_format($c['importe'], 2, ',', '.'); ?>€)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuenta y monedero -->
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="bi bi-wallet2 text-success me-2"></i>Cuenta y Monedero</h3>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="consumo" class="form-label small fw-bold text-secondary">Consumo Mensual Acumulado</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="consumo" id="consumo" class="form-control font-monospace" value="<?php echo $s['consumo'] ?? 0; ?>" <?php echo !$esAdminContable ? 'readonly' : ''; ?>>
                            <span class="input-group-text bg-light text-muted">g</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="saldo" class="form-label small fw-bold text-secondary">Saldo en Cuenta (Monedero prepago)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="saldo" id="saldo" class="form-control font-monospace fw-bold" value="<?php echo $s['saldo'] ?? 0; ?>" <?php echo !$esAdminContable ? 'readonly' : ''; ?>>
                            <span class="input-group-text bg-light text-muted">€</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary d-block">Estado de Admisión y Exención</label>
                        <div class="form-check form-switch mt-1 d-block">
                            <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" <?php echo intval($s['activo'] ?? 0) === 1 ? 'checked' : ''; ?> <?php echo !$esAdminContable ? 'disabled' : ''; ?>>
                            <label class="form-check-label small fw-bold text-dark" for="activo">Habilitado</label>
                        </div>
                        <div class="form-check form-switch mt-1 d-block">
                            <input class="form-check-input" type="checkbox" name="exento" id="exento" value="1" <?php echo intval($s['exento'] ?? 0) === 1 ? 'checked' : ''; ?> <?php echo !$esAdminContable ? 'disabled' : ''; ?>>
                            <label class="form-check-label small fw-bold text-success" for="exento">Exento Pago</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="<?php echo URL_ROOT; ?>/socios" class="btn btn-light border fw-bold px-4"><?php echo !$esAdminContable ? 'Volver Atrás' : 'Cancelar'; ?></a>
            <?php if ($esAdminContable): ?>
                <button type="submit" class="btn btn-success fw-bold px-4 shadow-sm">
                    <i class="bi bi-arrow-repeat me-1"></i> Guardar Cambios
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
</form>

<!-- MODAL: Foto de perfil ampliada -->
<?php if (!empty($s['imagen_perfil'])): ?>
<div class="modal fade" id="modalFotoPerfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold">Foto de perfil</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img src="<?php echo htmlspecialchars($fotoPerfil, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- MODAL: Documento ampliado (compartido por anverso/reverso) -->
<div class="modal fade" id="modalDocAmpliado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold" id="modalDocTitulo">Documento</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalDocImg" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Previsualización instantánea de la nueva foto de perfil antes de guardar
    var inputPerfil = document.getElementById('imagen_perfil');
    if (inputPerfil) {
        inputPerfil.addEventListener('change', function (e) {
            if (!e.target.files || !e.target.files[0]) return;
            var url = URL.createObjectURL(e.target.files[0]);
            var preview = document.getElementById('previewPerfil');
            if (preview.tagName === 'IMG') {
                preview.src = url;
            } else {
                var img = document.createElement('img');
                img.id = 'previewPerfil';
                img.src = url;
                preview.replaceWith(img);
            }
        });
    }

    // Previsualización instantánea de los documentos al elegir un archivo nuevo
    ['idFront', 'idBack'].forEach(function (campo) {
        var input = document.getElementById(campo);
        var thumb = document.getElementById('thumb_' + campo);
        if (input && thumb) {
            input.addEventListener('change', function (e) {
                if (!e.target.files || !e.target.files[0]) return;
                var url = URL.createObjectURL(e.target.files[0]);
                thumb.style.backgroundImage = "url('" + url + "')";
                var placeholder = thumb.querySelector('.doc-placeholder');
                if (placeholder) placeholder.remove();
                if (!thumb.querySelector('.doc-edit-overlay')) {
                    var overlay = document.createElement('span');
                    overlay.className = 'doc-edit-overlay';
                    overlay.innerHTML = '<button type="button" class="btn btn-sm btn-light doc-btn-ver" title="Ver ampliado"><i class="bi bi-eye-fill"></i></button>' +
                        '<button type="button" class="btn btn-sm btn-light doc-btn-cambiar" title="Sustituir documento"><i class="bi bi-pencil-fill"></i></button>';
                    thumb.appendChild(overlay);
                }
            });
        }
    });

    // Botones "Ver" y "Cambiar" de cada documento (delegación de eventos: los overlays se pueden recrear dinámicamente)
    document.querySelectorAll('.doc-thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function (e) {
            var campo = thumb.getAttribute('data-campo');

            if (e.target.closest('.doc-btn-cambiar')) {
                document.getElementById(campo).click();
                return;
            }
            if (thumb.style.backgroundImage) {
                var url = thumb.style.backgroundImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
                document.getElementById('modalDocTitulo').textContent = thumb.getAttribute('data-titulo');
                document.getElementById('modalDocImg').src = url;
                new bootstrap.Modal(document.getElementById('modalDocAmpliado')).show();
                return;
            }
            // Clic sobre el placeholder "Sin documento subido" -> abre directamente el selector de archivo
            if (e.target.closest('.doc-placeholder')) {
                document.getElementById(campo).click();
            }
        });
    });
});
</script>
