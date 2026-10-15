<?php
// /src/Views/dispensario/index.php
// Importamos el modelo físico en la cabecera para que la vista valide los interruptores del sistema
require_once ROOT_PATH . '/src/Models/Configuracion.php';

$socios = $socios ?? [];
$productos = $productos ?? [];
$categorias = $categorias ?? [];
?>

<!-- 🌟 LINK EXTERNO: Cargamos los estilos centralizados de mostrador desde la carpeta pública -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT; ?>/css/dispensario-tpv.css?v=<?php echo filemtime(ROOT_PATH . '/public/css/dispensario-tpv.css'); ?>">

<div class="row g-4">
    <!-- COLUMNA IZQUIERDA: CONFIGURACIÓN DE OPERACIÓN Y PRODUCTOS -->
    <div class="col-12 col-lg-8">

        <!-- 1. SELECCIONAR SOCIO EN MOSTRADOR -->
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="h6 fw-bold text-dark mb-0"><i class="fas fa-user-check text-success me-2"></i>1. Seleccionar Socio en Mostrador</h3>
            </div>
            <div class="card-body position-relative">
                <!-- Caja de entrada principal con el BOTÓN DE ALTA DE SOCIOS INTEGRADO -->
                <div class="d-flex flex-column flex-sm-row gap-2 mb-1">
                    <div class="input-group input-group-lg shadow-sm flex-grow-1">
                        <span class="input-group-text bg-white border-end-0 text-success"><i class="fas fa-search"></i></span>
                        <input type="text" id="buscar-socio" class="form-control border-start-0 fw-bold" placeholder="Nombre del socio..." autocomplete="off">
                    </div>

                    <div class="d-flex gap-2">
                        <!-- 🌟 BOTÓN DE ALTA DIRECTA DE SOCIOS: Visible y accesible para el dependiente raso -->
                        <a href="<?php echo URL_ROOT; ?>/socios/nuevo" class="btn btn-success fw-bold d-flex align-items-center justify-content-center gap-1 shadow-sm px-3 flex-fill" title="Registrar e Inscribir Socio Nuevo">
                            <i class="bi bi-person-plus-fill fs-5"></i> <span class="d-sm-none d-xl-inline">Inscribir Socio</span>
                        </a>

                        <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center flex-fill" type="button" id="btn-limpiar-socio" title="Limpiar selección">
                            <i class="bi bi-x-circle-fill me-1"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Lista flotante de sugerencias predictivas (Inicia oculta) -->
                <div id="sugerencias-socios" class="list-group position-absolute shadow-lg w-100 d-none" style="z-index: 1050; max-height: 250px; overflow-y: auto;"></div>

                <!-- Input oculto indispensable que guarda el ID del socio activo -->
                <input type="hidden" id="select-socio" value="">

                <!-- Tarjeta detallada con pestañas operativas (Inicia oculta) -->
                <div id="ficha-socio" class="card d-none border rounded rounded-3 shadow-sm mt-3 overflow-hidden bg-white">
                    <div class="card-header p-0 border-bottom bg-light">
                        <ul class="nav nav-tabs border-0 flex-nowrap" id="socioTabs" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link active w-100 fw-bold border-0 py-3 px-2 px-sm-4 position-relative btn-tab-custom" id="tab-operacion-link" data-bs-toggle="tab" data-bs-target="#panel-operacion" type="button" role="tab" aria-controls="panel-operacion" aria-selected="true" style="font-size: 13px; transition: all 0.2s ease;">
                                    <i class="bi bi-person-vcard me-2"></i>Ficha de Operación
                                </button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100 fw-bold border-0 py-3 px-2 px-sm-4 position-relative btn-tab-custom" id="tab-historial-link" data-bs-toggle="tab" data-bs-target="#panel-historial" type="button" role="tab" aria-controls="panel-historial" aria-selected="false" style="font-size: 13px; transition: all 0.2s ease; border-left: 1px solid rgba(0,0,0,0.08) !important;">
                                    <i class="bi bi-clock-history me-2"></i>Historial del Socio
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-3 tab-content" id="socioTabsContent">
                        <div class="tab-pane fade show active" id="panel-operacion" role="tabpanel" aria-labelledby="tab-operacion-link">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-2 text-center text-md-start mb-2 mb-md-0">
                                    <div id="socio-avatar" class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 65px; height: 65px; overflow: hidden; font-size: 24px;"></div>
                                </div>
                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                    <h4 id="socio-nombre" class="h5 fw-bold text-dark mb-1">Nombre Socio</h4>
                                    <div class="small text-muted mb-1"><i class="bi bi-card-text me-1"></i> Identificación: <span id="socio-dni" class="fw-semibold text-dark">-</span></div>
                                    <div class="small text-muted mb-1"><i class="bi bi-calendar-heart me-1"></i> Nacimiento: <span id="socio-nacimiento" class="fw-semibold text-dark">-</span> <span id="socio-cumple" class="badge bg-warning text-dark ms-1 d-none"><i class="bi bi-balloon-heart-fill me-1"></i>¡Hoy es su cumpleaños!</span></div>
                                    <div class="small text-muted mb-1"><i class="bi bi-activity me-1"></i> Previsión Consumo: <span id="socio-consumo" class="fw-semibold text-dark">0,00</span> g</div>
                                    <div class="small text-muted"><i class="bi bi-currency-euro me-1"></i> Saldo Monedero: <span id="txt-saldo-socio" class="fw-bold text-success">0,00</span> €</div>
                                    <div id="socio-documentos" class="d-flex gap-2 mt-2 d-none">
                                        <div class="text-center">
                                            <img id="socio-id-front" class="img-ampliable rounded border d-none" alt="DNI · Anverso" title="Ampliar DNI (anverso)" style="width: 84px; height: 54px; object-fit: cover;">
                                            <div class="text-muted" style="font-size: 10px;">Anverso</div>
                                        </div>
                                        <div class="text-center">
                                            <img id="socio-id-back" class="img-ampliable rounded border d-none" alt="DNI · Reverso" title="Ampliar DNI (reverso)" style="width: 84px; height: 54px; object-fit: cover;">
                                            <div class="text-muted" style="font-size: 10px;">Reverso</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 text-md-end">
                                    <button type="button" class="btn btn-sm btn-outline-success fw-bold shadow-sm py-2 px-3 d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalRecarga">
                                        <i class="bi bi-plus-circle"></i> Recargar Monedero
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="panel-historial" role="tabpanel" aria-labelledby="tab-historial-link">
                            <div id="tabla-extracto-socio" class="small"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. REJILLA DE CATÁLOGO COMPARTIDO DE PRODUCTOS -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom d-flex flex-column gap-3">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3 flex-grow-1">
                    <h3 class="h6 fw-bold text-dark mb-0 d-flex align-items-center text-nowrap"><i class="fas fa-th text-success me-2"></i>2. Artículos</h3>
                    <div class="input-group input-group-sm shadow-sm" style="max-width: 250px;">
                        <span class="input-group-text bg-light text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="buscar-producto" class="form-control" placeholder="Buscar artículo...">
                    </div>
                </div>

                <ul class="nav nav-pills tpv-categorias" id="pills-tab" aria-label="Filtrar artículos por categoría">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link btn-tpv-cat active fw-bold btn-filtro-cat" data-cat-id="todos" type="button"><i class="bi bi-grid" aria-hidden="true"></i><span>Todos</span></button>
                    </li>
                    <?php foreach ($categorias as $cat): ?>
                        <?php if (($cat['activo'] ?? 0) == 1): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn-tpv-cat fw-bold btn-filtro-cat" data-cat-id="<?php echo $cat['id_categoria']; ?>" type="button">
                                    <?php if (!empty($cat['icono'])): ?>
                                        <i class="bi <?php echo htmlspecialchars($cat['icono'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
                                    <?php endif; ?>
                                    <span><?php echo htmlspecialchars($cat['categoria'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                                </button>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card-body">
                <div class="row row-cols-2 row-cols-md-3 g-2 g-sm-3" id="rejilla-productos">
                    <?php foreach ($productos as $p): ?>
                        <?php
                        $stockDisponible = floatval($p['dispensario'] ?? 0);
                        $esVisible       = intval($p['visible'] ?? 0) === 1;

                        if ($esVisible && $stockDisponible > 0):
                        ?>
                            <div class="col item-producto-tpv" data-categoria-id="<?php echo $p['categoria_id']; ?>">
                                <div class="card h-100 border text-center p-3 position-relative transition-all btn-agregar hover-shadow"
                                    style="cursor: pointer;"
                                    data-id="<?php echo $p['id_producto']; ?>"
                                    data-nombre="<?php echo htmlspecialchars($p['producto'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    data-precio="<?php echo $p['pvp'] ?? 0; ?>"
                                    data-stock="<?php echo $stockDisponible; ?>"
                                    data-servicio-id="<?php echo $p['servicio_id']; ?>">

                                    <div class="rounded bg-light mb-2 mx-auto d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; overflow: hidden;">
                                        <img src="<?php echo htmlspecialchars(Demo::urlImagen('productos', $p['imagen_producto']), ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid img-ampliable" alt="<?php echo htmlspecialchars($p['producto'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" title="Ampliar imagen" style="object-fit: cover; width:100%; height:100%;" onerror="this.onerror=null; this.src='https://placehold.co';">
                                    </div>

                                    <h4 class="h6 fw-bold text-dark mb-1 text-truncate" style="max-width: 100%;"><?php echo htmlspecialchars($p['producto'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h4>
                                    <div class="text-success fw-bold font-monospace small mb-1"><?php echo number_format($p['pvp'] ?? 0, 2, ',', '.'); ?> €</div>
                                    <small class="text-muted d-block text-uppercase" style="font-size: 10px;">Stock: <?php echo number_format($stockDisponible, 2, ',', '.'); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- COLUMNA DERECHA: CESTA / CARRITO MULTILINEAL -->
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm border-0 rounded-3 sticky-lg-top" style="top: 20px;">
            <div class="card-header bg-dark text-white py-3">
                <h3 class="h6 fw-bold mb-0"><i class="fas fa-shopping-basket text-warning me-2"></i>Resumen de Dispensación</h3>
            </div>
            <div class="card-body p-0">
                <div id="contenedor-carrito" class="p-3" style="max-height: 350px; overflow-y: auto;">
                    <p class="text-muted text-center py-4 my-0 small"><i class="fas fa-receipt d-block display-6 text-light-underline mb-2 text-secondary"></i>La cesta está vacía.<br>Seleccione un socio e incluya artículos del mostrador.</p>
                </div>
                <div class="bg-light p-3 border-top">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary small fw-bold">Total a descontar:</span>
                        <span id="txt-total-carrito" class="font-monospace fw-bold text-dark" style="font-size:1.15rem;">0,00 €</span>
                    </div>
                    <button id="btn-cobrar" class="btn btn-success btn-lg w-100 fw-bold mt-2 shadow-sm d-flex align-items-center justify-content-center gap-2" disabled>
                        <i class="bi bi-cash-register" style="font-size: 1.25rem;"></i> Confirmar Retirada
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImagenProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header py-2">
                <h5 class="modal-title h6 fw-bold mb-0" id="modalImagenTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img id="modalImagenSrc" src="" alt="" class="img-fluid rounded" style="max-height: 70vh;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRecarga" tabindex="-1" aria-labelledby="modalRecargaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white py-2.5">
                <h5 class="modal-title h6 fw-bold mb-0" id="modalRecargaLabel"><i class="fas fa-money-bill-wave me-1"></i> Recarga de Saldo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="mb-3">
                    <label for="input-monto" class="form-label small fw-bold text-secondary">Importe a añadir (€) *</label>
                    <div class="input-group">
                        <input type="number" id="input-monto" class="form-control form-control-lg font-monospace text-center text-success fw-bold" step="5" min="1" placeholder="0.00" autofocus>
                        <span class="input-group-text bg-light fw-bold">€</span>
                    </div>
                </div>
                <div class="row row-cols-3 g-2 mb-3">
                    <div class="col"><button type="button" class="btn btn-sm btn-outline-secondary w-100 py-1.5 fw-bold font-monospace btn-fast" data-val="10">+10€</button></div>
                    <div class="col"><button type="button" class="btn btn-sm btn-outline-secondary w-100 py-1.5 fw-bold font-monospace btn-fast" data-val="20">+20€</button></div>
                    <div class="col"><button type="button" class="btn btn-sm btn-outline-secondary w-100 py-1.5 fw-bold font-monospace btn-fast" data-val="50">+50€</button></div>
                </div>
                <button type="button" id="btn-guardar-recarga" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                    <i class="fas fa-check-circle me-1"></i> Confirmar Recarga
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-3">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #1b4332; border-bottom: 2px solid #ffc107;">
                <h3 class="h6 fw-bold mb-0 text-white"><i class="fas fa-history text-warning me-2"></i>Auditoría: Historial y Balance de Caja del Día</h3>
                <span class="badge bg-warning text-dark rounded-pill fw-bold small px-3">Jornada de Hoy</span>
            </div>

            <div class="card-body p-0 bg-white">
                <?php if (!isset($ventasDelDia) || count($ventasDelDia) === 0): ?>
                    <div class="text-center py-5 text-muted small">
                        <i class="fas fa-receipt d-block display-5 text-muted opacity-25 mb-2"></i>
                        No se han registrado operaciones de dispensación en la jornada de hoy.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light text-secondary fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="px-4 py-3" style="width: 170px;">Fecha / Hora</th>
                                    <th class="py-3">Socio / Miembro</th>
                                    <th class="py-3">Artículo Dispensado</th>
                                    <th class="py-3 text-center" style="width: 160px;">Cantidad Servida</th>
                                    <th class="py-3 text-end" style="width: 150px;">Importe Debitado</th>
                                    <th class="px-4 py-3 text-center" style="width: 220px;">Acciones Autorizadas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ventasDelDia as $v):
                                    $fechaTpv = date('d/m/Y', strtotime($v['date_add_venta']));
                                    $horaTpv = date('H:i:s', strtotime($v['date_add_venta']));
                                ?>
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 text-muted font-monospace" style="white-space:nowrap;">
                                            <?php echo $fechaTpv; ?> <span class="text-xs text-secondary opacity-75"><?php echo $horaTpv; ?></span>
                                        </td>
                                        <td class="fw-semibold text-dark"><?php echo htmlspecialchars(($v['socio_nombre'] ?? '') . ' ' . ($v['socio_apellidos'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-bold text-uppercase" style="font-size: 11px;">
                                                <?php echo htmlspecialchars($v['producto'] ?? 'Artículo', ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <td class="text-center font-monospace fw-bold text-secondary">
                                            <?php echo number_format($v['cantidad'], 2, ',', '.'); ?>
                                            <small class="text-lowercase text-muted fw-normal"><?php echo (intval($v['servicio_id'] ?? 2) === 1) ? 'g' : 'ud'; ?></small>
                                        </td>
                                        <td class="text-end font-monospace fw-bold text-danger">-<?php echo number_format($v['importe_total'] ?? 0, 2, ',', '.'); ?> €</td>
                                        <td class="px-4 text-center">
                                            <div class="d-flex justify-content-center gap-1.5">
                                                <?php
                                                $cfgSistema = Configuracion::all();
                                                $mostrarPdfActivo    = (intval($cfgSistema['generar_factura_pdf'] ?? 1) === 1);
                                                $mostrarTicketActivo = (intval($cfgSistema['imprimir_ticket_termico'] ?? 1) === 1);

                                                if ($mostrarTicketActivo):
                                                ?>
                                                    <a href="#" onclick="window.open('<?php echo URL_ROOT; ?>/dispensario/ticket?id=<?php echo $v['id_venta']; ?>', 'Ticket', 'width=400,height=600,navigable=no,resizable=yes'); return false;" class="btn btn-sm btn-outline-success fw-bold shadow-sm py-1 px-2" title="Imprimir resguardo térmico">
                                                        <i class="bi bi-receipt"></i> Ticket
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($mostrarPdfActivo): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/dispensario/factura?id=<?php echo $v['id_venta']; ?>" target="_blank" class="btn btn-sm btn-outline-primary fw-bold shadow-sm py-1 px-2" title="Imprimir Factura A4">
                                                        <i class="bi bi-file-earmark-pdf-fill"></i> Factura
                                                    </a>
                                                <?php endif; ?>

                                                <!-- 🌟 CANDADO DE SEGURIDAD ABSOLUTO ANTI-FRAUDE INTERNO: 
                                                     El botón de Anular SOLO se dibuja si el operario tiene asignado el permiso granular 'edit_roles'.
                                                     Como en tu volcado SQL la columna 'edit_roles' está apagada (0) para vendedores y colaboradores,
                                                     la opción se evapora por completo de su monitor, impidiendo desvíos o manipulaciones de stock. -->
                                                <?php if (intval($_SESSION['permisos']['edit_roles'] ?? 0) === 1): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/dispensario/anular?id=<?php echo $v['id_venta']; ?>" class="btn btn-sm btn-outline-danger fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-1 py-1 px-2.5" onclick="return confirm('¿Confirmas que deseas ANULAR este ticket?');">
                                                        <i class="bi bi-trash3-fill"></i> Anular
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    window.ENV_URL_ROOT = "<?php echo URL_ROOT; ?>";

    const bancoDatosSocios = [
        <?php foreach ($socios as $s): ?>
            <?php if (($s['activo'] ?? 0) == 1): ?> {
                    id: "<?php echo $s['id_socio']; ?>",
                    nombre: "<?php echo htmlspecialchars(($s['nombre'] ?? '') . ' ' . ($s['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>",
                    saldo: "<?php echo $s['saldo']; ?>",
                    search: "<?php echo strtolower(htmlspecialchars(($s['nombre'] ?? '') . ' ' . ($s['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8')); ?>"
                },
            <?php endif; ?>
        <?php endforeach; ?>
    ];
</script>
<script src="<?php echo URL_ROOT; ?>/js/dispensario-tpv.js?v=<?php echo filemtime(ROOT_PATH . '/public/js/dispensario-tpv.js'); ?>"></script>