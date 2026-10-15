<?php $esc = static function ($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); }; ?>
<div class="mb-4">
    <a href="<?php echo URL_ROOT; ?>/informes" class="btn btn-outline-secondary mb-3">Volver a informes</a>
    <h2 class="h4">Uso de la demo y sugerencias</h2>
    <p class="text-muted">Registro permanente de visitas. Las repeticiones se detectan por email declarado, no verificado.</p>
</div>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert"><?php echo $esc($error); ?></div>
<?php else: ?>
    <div class="row g-3 mb-4">
        <?php foreach (['usos' => 'Usos de la demo', 'visitantes' => 'Emails distintos', 'repetidores' => 'Visitantes que repiten', 'sugerencias' => 'Sugerencias recibidas'] as $clave => $etiqueta): ?>
            <div class="col-6 col-lg-3"><div class="card card-body shadow-sm border-0">
                <span class="small text-muted"><?php echo $etiqueta; ?></span>
                <strong class="fs-4"><?php echo (int) $registro['totales'][$clave]; ?></strong>
            </div></div>
        <?php endforeach; ?>
    </div>
    <div class="card card-body border-0 shadow-sm mb-4">
        <h2 class="h5">Cómo se está usando la demo</h2>
        <p class="small text-muted">Actividad aproximada: <?php echo round($registro['totales']['segundos_activos'] / 60, 1); ?> minutos.
            Facilidad media: <?php echo $registro['totales']['facilidad'] !== null ? number_format((float) $registro['totales']['facilidad'], 1, ',', '.') . '/5' : 'Sin valoraciones'; ?>.
            Solo medimos intervalos con la página visible e interacción reciente; no es un cronómetro exacto ni una grabación.</p>
        <div class="table-responsive">
            <table class="table table-sm"><thead><tr><th>Sección</th><th>Acción</th><th>Veces</th><th>Errores detectados</th><th>Resultado sin confirmar</th></tr></thead>
                <tbody>
                <?php foreach ($registro['resumen'] as $dato): ?>
                    <tr><td><?php echo $esc($dato['seccion']); ?></td><td><?php echo $esc($dato['accion']); ?></td><td><?php echo (int) $dato['cantidad']; ?></td><td><?php echo (int) $dato['errores']; ?></td><td><?php echo (int) $dato['desconocidos']; ?></td></tr>
                <?php endforeach; ?>
                <?php if (!$registro['resumen']): ?><tr><td colspan="5">Todavía no hay actividad registrada con el nuevo análisis.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
        <p class="small text-muted mb-0">No se guardan nombres de socios/productos de prueba, importes, fotos, campos de formularios, parámetros de URL ni contenido de errores. Las acciones antiguas sin confirmación explícita se muestran como «desconocido», no como éxitos.</p>
    </div>
    <div class="table-responsive card shadow-sm border-0">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light"><tr><th>Visitante</th><th>Email</th><th>Inicio</th><th>Fin / estado</th><th>Repeticiones</th><th>Actividad y valoración</th><th>Sugerencias</th></tr></thead>
            <tbody>
                <?php if (!$registro['filas']): ?><tr><td colspan="7" class="text-center text-muted py-4">Todavía no se ha utilizado la demo con el nuevo registro.</td></tr><?php endif; ?>
                <?php foreach ($registro['filas'] as $visita): ?>
                    <tr>
                        <td><?php echo $esc($visita['nombre']); ?></td>
                        <td><?php echo $esc($visita['email']); ?></td>
                        <td class="text-nowrap"><?php echo $esc($visita['inicio']); ?></td>
                        <td class="text-nowrap">
                            <?php echo $esc($visita['fin'] ?? 'Sin salida registrada'); ?><br>
                            <?php echo $visita['estado'] === 'activa' && $visita['caducada'] ? 'Caducada (pendiente de limpieza)' : $esc($visita['estado']); ?>
                        </td>
                        <td>
                            Visita <?php echo (int) $visita['numero_visita']; ?> de <?php echo (int) $visita['usos_visitante']; ?>
                            <?php if ((int) $visita['numero_visita'] > 1): ?><span class="badge bg-info-subtle text-info-emphasis">Ha repetido</span><?php endif; ?>
                        </td>
                        <td style="min-width: 250px;">
                            <?php echo round($visita['duracion'] / 60, 1); ?> min desde el inicio<br>
                            <?php echo round($visita['segundos_activos'] / 60, 1); ?> min activos aprox.<br>
                            Última actividad: <?php echo $esc($visita['ultima_actividad'] ?? 'Sin actividad medida'); ?><br>
                            Facilidad: <?php echo $visita['facilidad'] !== null ? (int) $visita['facilidad'] . '/5' : 'Sin valorar'; ?><br>
                            Instalaría: <?php echo $esc(['si' => 'Sí', 'quizas' => 'Quizás', 'no' => 'No'][$visita['instalaria']] ?? 'Sin respuesta'); ?>
                            <details class="mt-2">
                                <summary>Ver recorrido</summary>
                                <ol class="small ps-3 mt-2">
                                    <?php foreach ($registro['eventos'][$visita['id']] ?? [] as $evento): ?>
                                        <li><?php echo $esc($evento['fecha'] . ' · ' . $evento['seccion'] . ' / ' . $evento['accion'] . ' · ' . $evento['resultado']); ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            </details>
                        </td>
                        <td style="min-width: 220px; max-width: 400px; overflow-wrap: anywhere;">
                            <?php echo $visita['sugerencias'] !== null ? nl2br($esc($visita['sugerencias'])) : ($visita['sugerencias_fecha'] ? 'Salió sin sugerencias' : 'Sin respuesta'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav class="d-flex flex-wrap justify-content-between gap-2 mt-3" aria-label="Paginación del uso de demo">
        <span>Página <?php echo $registro['pagina']; ?> de <?php echo $registro['paginas']; ?></span>
        <div class="d-flex gap-2">
            <?php if ($registro['pagina'] > 1): ?><a class="btn btn-outline-secondary btn-sm" href="<?php echo URL_ROOT; ?>/informes/demo?pagina=<?php echo $registro['pagina'] - 1; ?>">Anterior</a><?php endif; ?>
            <?php if ($registro['pagina'] < $registro['paginas']): ?><a class="btn btn-outline-secondary btn-sm" href="<?php echo URL_ROOT; ?>/informes/demo?pagina=<?php echo $registro['pagina'] + 1; ?>">Siguiente</a><?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
