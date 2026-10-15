<?php 
// /src/Views/configuracion/index.php
$cfg = $opciones_sistema ?? [];
$ticketActivo = intval($cfg['imprimir_ticket_termico'] ?? 1) === 1;
$pdfActivo    = intval($cfg['generar_factura_pdf'] ?? 1) === 1;
$margenBeneficio = is_numeric($cfg['margen_beneficio'] ?? null) ? $cfg['margen_beneficio'] : '30';
?>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-gear-widg-set text-success"></i> Opciones del Sistema y Módulos de Caja
        </h2>
    </div>
    
    <div class="card-body p-4">
        <form action="<?php echo URL_ROOT; ?>/configuracion/guardar" method="POST" autocomplete="off">
            <h3 class="h6 fw-bold text-secondary text-uppercase border-bottom pb-2 mb-4">
                <i class="bi bi-printer me-1"></i> Preferencias de Facturación y Salidas de Impresión
            </h3>
            
            <div class="row g-4 mb-4">
                <!-- Módulo 1: Ticket Térmico -->
                <div class="col-12 col-md-6">
                    <div class="border rounded-3 p-4 bg-light shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-receipt text-success display-6"></i>
                                <span class="fw-bold text-dark h5 mb-0">Impresión de Ticket Térmico</span>
                            </div>
                            <small class="text-muted d-block lh-base">
                                Genera una simulación en ventana emergente con el formato estrecho estándar de **80mm** apto para impresoras térmicas de tickets. Ideal para el dependiente y control rápido del socio.
                            </small>
                        </div>
                        
                        <div class="form-check form-switch pt-3 border-top mt-3 mb-0">
                            <input class="form-check-input" type="checkbox" name="imprimir_ticket_termico" id="imprimir_ticket_termico" value="1" <?php echo $ticketActivo ? 'checked' : ''; ?>>
                            <label class="form-check-label small fw-bold text-success" for="imprimir_ticket_termico">Módulo de Ticket Activado</label>
                        </div>
                    </div>
                </div>

                <!-- Módulo 2: Factura Folio A4 -->
                <div class="col-12 col-md-6">
                    <div class="border rounded-3 p-4 bg-light shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-file-earmark-pdf text-primary display-6"></i>
                                <span class="fw-bold text-dark h5 mb-0">Factura Simplificada en PDF (A4)</span>
                            </div>
                            <small class="text-muted d-block lh-base">
                                Genera un documento PDF formal y estructurado en tamaño **Folio A4** utilizando la librería local. Incluye cabeceras, desglose contable y un entorno óptimo para reportes y auditoría del club.
                            </small>
                        </div>
                        
                        <div class="form-check form-switch pt-3 border-top mt-3 mb-0">
                            <input class="form-check-input" type="checkbox" name="generar_factura_pdf" id="generar_factura_pdf" value="1" <?php echo $pdfActivo ? 'checked' : ''; ?>>
                            <label class="form-check-label small fw-bold text-primary" for="generar_factura_pdf">Módulo de Factura A4 Activado</label>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="h6 fw-bold text-secondary text-uppercase border-bottom pb-2 mb-4">
                <i class="bi bi-percent me-1"></i> Precios de Productos
            </h3>

            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6">
                    <div class="border rounded-3 p-4 bg-light shadow-sm h-100">
                        <label for="margen_beneficio" class="fw-bold text-dark h5 mb-2 d-block">Porcentaje de beneficio</label>
                        <small class="text-muted d-block lh-base mb-3">
                            Se aplica sobre el precio de compra para calcular el <strong>precio orientativo</strong> en la ficha del producto
                            (precio de compra + porcentaje). Es solo una referencia: el PVP se sigue fijando a mano.
                        </small>
                        <div class="input-group" style="max-width: 220px;">
                            <input type="number" step="0.01" min="0" max="1000" name="margen_beneficio" id="margen_beneficio"
                                class="form-control fw-bold font-monospace" value="<?php echo htmlspecialchars($margenBeneficio, ENT_QUOTES, 'UTF-8'); ?>" required>
                            <span class="input-group-text bg-white fw-bold">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-top d-flex gap-2">
                <a href="<?php echo URL_ROOT; ?>/" class="btn btn-light border fw-bold px-4">Cancelar</a>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Guardar Configuración
                </button>
            </div>
        </form>
    </div>
</div>
