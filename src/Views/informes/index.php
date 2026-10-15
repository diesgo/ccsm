<?php
$esc = static function ($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); };
$numero = static function ($valor) { return number_format((float) $valor, 2, ',', '.'); };
$urlInforme = static function ($cambios) use ($filtros) {
    return URL_ROOT . '/informes?' . http_build_query(array_merge($filtros, $cambios));
};
$tipo = $filtros['tipo'];
$agrupado = in_array($tipo, ['productos', 'socios'], true);
?>
<div class="mb-4">
    <h2 class="fw-bold text-dark"><i class="bi bi-bar-chart-line text-success me-2" aria-hidden="true"></i>Informes</h2>
    <p class="text-muted mb-0">Historial y resumen de las operaciones registradas.</p>
</div>
<nav class="nav nav-pills flex-wrap gap-2 mb-4" aria-label="Tipos de informe">
    <?php foreach (Informe::TIPOS as $clave => $nombre): ?>
        <a class="nav-link <?php echo $tipo === $clave ? 'active' : ''; ?>"
            <?php echo $tipo === $clave ? 'aria-current="page"' : ''; ?>
            href="<?php echo $esc($urlInforme(['tipo' => $clave, 'pagina' => 1, 'socio' => 0, 'proveedor' => 0])); ?>"><?php echo $esc($nombre); ?></a>
    <?php endforeach; ?>
</nav>
<?php if (!Demo::activa()): ?>
    <a class="btn btn-outline-secondary mb-4" href="<?php echo URL_ROOT; ?>/informes/demo"><i class="bi bi-people me-1" aria-hidden="true"></i> Uso de la demo y sugerencias</a>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert"><?php echo $esc($error); ?></div>
<?php else: ?>
    <form method="GET" action="<?php echo URL_ROOT; ?>/informes" class="card card-body border-0 shadow-sm mb-4">
        <input type="hidden" name="tipo" value="<?php echo $esc($tipo); ?>">
        <div class="row g-3 align-items-end">
            <?php foreach (['desde' => 'Desde', 'hasta' => 'Hasta (inclusive)'] as $campo => $etiqueta): ?>
                <div class="col-12 col-sm-6 col-lg-2">
                    <label for="informe-<?php echo $campo; ?>" class="form-label small fw-bold"><?php echo $etiqueta; ?></label>
                    <input type="date" id="informe-<?php echo $campo; ?>" name="<?php echo $campo; ?>" class="form-control" value="<?php echo $esc($filtros[$campo]); ?>">
                </div>
            <?php endforeach; ?>
            <?php foreach (['producto' => ['productos', 'Producto'], $tipo === 'compras' ? 'proveedor' : 'socio' => $tipo === 'compras' ? ['proveedores', 'Proveedor'] : ['socios', 'Socio']] as $campo => [$lista, $etiqueta]): ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="informe-<?php echo $campo; ?>" class="form-label small fw-bold"><?php echo $etiqueta; ?></label>
                    <select name="<?php echo $campo; ?>" id="informe-<?php echo $campo; ?>" class="form-select">
                        <option value="0">Todos</option>
                        <?php foreach ($opciones[$lista] as $opcion): ?>
                            <option value="<?php echo (int) $opcion['id']; ?>" <?php echo $filtros[$campo] === (int) $opcion['id'] ? 'selected' : ''; ?>>
                                #<?php echo (int) $opcion['id']; ?> · <?php echo $esc($opcion['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
            <div class="col-12 col-lg-2 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-success">Filtrar</button>
                <a href="<?php echo $esc(URL_ROOT . '/informes?tipo=' . $tipo); ?>" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </div>
    </form>
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4"><div class="card card-body border-0 shadow-sm">
            <span class="text-muted small">Líneas de <?php echo $tipo === 'compras' ? 'compra' : 'venta'; ?></span>
            <strong class="fs-4"><?php echo (int) $informe['totales']['operaciones']; ?></strong>
        </div></div>
        <div class="col-12 col-md-4"><div class="card card-body border-0 shadow-sm">
            <span class="text-muted small">Importe registrado (todo el filtro)</span>
            <strong class="fs-4"><?php echo $numero($informe['totales']['importe']); ?> €</strong>
        </div></div>
        <div class="col-12 col-md-4"><div class="card card-body border-0 shadow-sm">
            <span class="text-muted small">Cantidades (medida actual de la categoría)</span>
            <strong><?php echo $numero($informe['totales']['unidades']); ?> ud · <?php echo $numero($informe['totales']['gramos']); ?> g</strong>
            <?php if ((float) $informe['totales']['sin_medida'] !== 0): ?>
                <span class="text-warning small"><?php echo $numero($informe['totales']['sin_medida']); ?> sin medida asignada</span>
            <?php endif; ?>
        </div></div>
    </div>
    <p class="small text-muted">Cada registro corresponde a una línea, no a un ticket completo. Las ventas anuladas no aparecen: el sistema las elimina. Los nombres y unidades corresponden al catálogo actual.</p>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white fw-bold"><?php echo $esc(Informe::TIPOS[$tipo]); ?> · <?php echo (int) $informe['registros']; ?> resultado(s)</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light"><tr>
                    <?php if ($agrupado): ?>
                        <th class="px-3"><?php echo $tipo === 'productos' ? 'Producto' : 'Socio'; ?></th>
                        <th class="text-end">Líneas de venta</th>
                        <th class="text-end">Cantidad</th>
                    <?php else: ?>
                        <th class="px-3">ID</th><th>Fecha / hora</th><th>Producto</th>
                        <th><?php echo $tipo === 'compras' ? 'Proveedor' : 'Socio'; ?></th><th class="text-end">Cantidad</th>
                        <?php if ($tipo === 'compras'): ?><th class="text-end">Coste unitario</th><th class="text-end">IVA</th><?php endif; ?>
                    <?php endif; ?>
                    <th class="text-end px-3">Importe</th>
                </tr></thead>
                <tbody>
                    <?php if (!$informe['filas']): ?>
                        <tr><td colspan="<?php echo $agrupado ? 4 : ($tipo === 'compras' ? 8 : 6); ?>" class="text-center text-muted py-5">No hay operaciones para los filtros seleccionados.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($informe['filas'] as $fila): ?>
                        <tr>
                            <?php if ($agrupado): ?>
                                <td class="px-3">#<?php echo (int) $fila['id']; ?> · <?php echo $esc($fila['nombre'] ?: 'No disponible'); ?></td>
                                <td class="text-end"><?php echo (int) $fila['operaciones']; ?></td>
                                <td class="text-end">
                                    <?php if ($tipo === 'socios'): ?>
                                        <?php echo $numero($fila['unidades']); ?> ud · <?php echo $numero($fila['gramos']); ?> g
                                        <?php if ((float) $fila['sin_medida'] !== 0): ?><br><?php echo $numero($fila['sin_medida']); ?> sin medida<?php endif; ?>
                                    <?php else: ?>
                                        <?php echo $numero($fila['cantidad']); ?> · <?php echo $esc($fila['servicio'] ?? 'Sin medida'); ?>
                                    <?php endif; ?>
                                </td>
                            <?php else: ?>
                                <td class="px-3">#<?php echo (int) $fila['id']; ?></td>
                                <td class="text-nowrap"><?php echo $esc(date('d/m/Y H:i:s', strtotime($fila['fecha']))); ?></td>
                                <td>#<?php echo (int) $fila['producto_id']; ?> · <?php echo $esc($fila['producto'] ?? 'No disponible'); ?></td>
                                <td>#<?php echo (int) $fila['entidad_id']; ?> · <?php echo $esc($fila['entidad'] ?: 'No disponible'); ?></td>
                                <td class="text-end"><?php echo $numero($fila['cantidad']); ?> · <?php echo $esc($fila['servicio'] ?? 'Sin medida'); ?></td>
                                <?php if ($tipo === 'compras'): ?><td class="text-end"><?php echo $numero($fila['pcm']); ?> €</td><td class="text-end"><?php echo (int) $fila['iva']; ?>%</td><?php endif; ?>
                            <?php endif; ?>
                            <td class="text-end px-3 text-nowrap fw-bold"><?php echo $numero($fila['importe']); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <nav class="d-flex flex-wrap align-items-center justify-content-between gap-2" aria-label="Paginación del informe">
        <span class="small text-muted">Página <?php echo $informe['pagina']; ?> de <?php echo $informe['paginas']; ?> · <?php echo Informe::TAMANO_PAGINA; ?> resultados por página</span>
        <div class="d-flex gap-2">
            <?php if ($informe['pagina'] > 1): ?><a class="btn btn-outline-secondary btn-sm" href="<?php echo $esc($urlInforme(['pagina' => $informe['pagina'] - 1])); ?>">Anterior</a><?php endif; ?>
            <?php if ($informe['pagina'] < $informe['paginas']): ?><a class="btn btn-outline-secondary btn-sm" href="<?php echo $esc($urlInforme(['pagina' => $informe['pagina'] + 1])); ?>">Siguiente</a><?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
