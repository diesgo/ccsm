<?php
// /src/Views/compras/crear.php
$proveedores = $proveedores ?? [];
$productos   = $productos ?? [];
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <!-- Cabecera Corporativa Verde Forestal -->
            <div class="card-header text-white py-3" style="background-color: #1b4332; border-bottom: 2px solid #ffc107;">
                <h3 class="h6 fw-bold mb-0"><i class="fas fa-truck-loading me-2 text-warning"></i> Registrar Albarán de Compra (Entrada de Almacén)</h3>
            </div>

            <div class="card-body p-4 bg-white">
                <form action="<?php echo URL_ROOT; ?>/compras/guardar" method="POST" autocomplete="off">

                    <div class="row g-3 mb-4">
                        <!-- 1. SELECCIÓN DE PROVEEDOR -->
                        <div class="col-12 col-md-6">
                            <label for="proveedor_id" class="form-label small fw-bold text-secondary">Proveedor Recibido *</label>
                            <select name="proveedor_id" id="proveedor_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="" disabled selected>-- Seleccione Proveedor --</option>
                                <?php foreach ($proveedores as $prov): ?>
                                    <option value="<?php echo $prov['id_proveedor']; ?>">
                                        <?php echo htmlspecialchars($prov['proveedor'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 2. SELECCIÓN DE ARTÍCULO -->
                        <div class="col-12 col-md-6">
                            <label for="producto_id" class="form-label small fw-bold text-secondary">Artículo a Abastecer *</label>
                            <select name="producto_id" id="producto_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="" disabled selected>-- Seleccione Artículo --</option>
                                <?php foreach ($productos as $p): ?>
                                    <option value="<?php echo $p['id_producto']; ?>" data-servicio="<?php echo $p['servicio_id']; ?>">
                                        <?php echo htmlspecialchars($p['producto'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- BLOQUE DE CÁLCULO FINANCIERO EXTENDIDO CON ESTIMACIÓN DE PVP -->
                    <div class="row g-3 p-3 rounded rounded-3 bg-light border mb-4">

                        <!-- 1. PRECIO DE COSTO (PCM) -->
                        <div class="col-12 col-sm-3">
                            <label for="pcm" class="form-label small fw-bold text-secondary">Precio Costo / Unidad (€) *</label>
                            <div class="input-group">
                                <input type="number" name="pcm" id="pcm" class="form-control form-control-lg font-monospace text-center text-dark fw-bold" step="0.01" min="0.01" placeholder="0.00" required>
                                <span class="input-group-text bg-white">€</span>
                            </div>
                        </div>

                        <!-- 2. MARGEN DE BENEFICIO DEL CLUB (%) -->
                        <div class="col-12 col-sm-3">
                            <label for="margen" class="form-label small fw-bold text-secondary">Margen Comercial (%) *</label>
                            <div class="input-group">
                                <input type="number" id="margen" class="form-control form-control-lg font-monospace text-center text-primary fw-bold" min="0" value="40" placeholder="0">
                                <span class="input-group-text bg-white text-primary fw-bold">%</span>
                            </div>
                        </div>

                        <!-- 3. UNIDADES O GRAMOS -->
                        <div class="col-12 col-sm-3">
                            <label for="unidades" class="form-label small fw-bold text-secondary" id="label-medida">Cantidad a ingresar *</label>
                            <div class="input-group">
                                <input type="number" name="unidades" id="unidades" class="form-control form-control-lg font-monospace text-center text-dark fw-bold" step="1" min="1" placeholder="0" required>
                                <span class="input-group-text bg-white fw-bold text-muted" id="badge-medida">ud</span>
                            </div>
                        </div>

                        <!-- 4. IMPUESTO IVA (%) -->
                        <div class="col-12 col-sm-3">
                            <label for="iva" class="form-label small fw-bold text-secondary">Tasa IVA Aplicada (%) *</label>
                            <select name="iva" id="iva" class="form-select form-select-lg font-monospace text-center text-dark fw-bold" required>
                                <option value="21" selected>21% (Estándar)</option>
                                <option value="10">10% (Reducido)</option>
                                <option value="4">4% (Superreducido)</option>
                                <option value="0">0% (Exento)</option>
                            </select>
                        </div>
                    </div>

                    <!-- TARJETAS DE TOTALES CON CAMPO DE PVP EDITABLE POR EL OPERADOR -->
                    <div class="row g-3 mb-4 text-center align-items-center">
                        <!-- A. SUBTOTAL NETO -->
                        <div class="col-12 col-md-4">
                            <div class="p-2 border rounded bg-white shadow-sm h-100">
                                <small class="text-uppercase text-muted d-block fw-bold mb-1" style="font-size:10px;">Subtotal Neto (Costo)</small>
                                <span id="txt-subtotal" class="font-monospace fw-bold text-secondary h5">0,00 €</span>
                                <input type="hidden" name="subtotal" id="input-subtotal" value="0.00">
                            </div>
                        </div>

                        <!-- B. PVP FINAL EDITABLE (La Sugerencia Modificable) -->
                        <div class="col-12 col-md-4">
                            <div class="p-2 border rounded bg-white shadow-sm border-primary h-100">
                                <label for="input-pvp" class="text-uppercase text-primary d-block fw-bold mb-1" style="font-size:10px;">💡 PVP Venta Final (€)</label>
                                <div class="input-group input-group-sm px-2">
                                    <input type="number" name="pvp_nuevo" id="input-pvp" class="form-control text-center font-monospace fw-bold text-primary" step="0.01" min="0.00" value="0.00" title="Sugerencia automática. Modifíquelo libremente si lo requiere.">
                                    <span class="input-group-text bg-light text-primary fw-bold">€</span>
                                </div>
                                <small class="text-muted d-block mt-1 opacity-75" style="font-size:9px;">Puedes modificar este precio manual</small>
                            </div>
                        </div>

                        <!-- C. TOTAL ALBARÁN -->
                        <div class="col-12 col-md-4">
                            <div class="p-2 border rounded text-white shadow-sm h-100" style="background-color: #1b4332;">
                                <small class="text-uppercase text-warning d-block fw-bold mb-1" style="font-size:10px;">Total Albarán (Con IVA)</small>
                                <span id="txt-total" class="font-monospace fw-bold h5">0,00 €</span>
                                <input type="hidden" name="total" id="input-total" value="0.00">
                            </div>
                        </div>
                    </div>



                    <!-- TOTALES DEL ALBARÁN CALCULADOS EN EN CALIENTE -->
                    <div class="row g-3 mb-4 text-center">
                        <div class="col-6">
                            <div class="p-2 border rounded bg-white shadow-sm">
                                <small class="text-uppercase text-muted d-block fw-bold" style="font-size:10px;">Subtotal Neto</small>
                                <span id="txt-subtotal" class="font-monospace fw-bold text-secondary h5">0,00 €</span>
                                <input type="hidden" name="subtotal" id="input-subtotal" value="0.00">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded text-white shadow-sm" style="background-color: #1b4332;">
                                <small class="text-uppercase text-warning d-block fw-bold" style="font-size:10px;">Total Albarán (Con IVA)</small>
                                <span id="txt-total" class="font-monospace fw-bold h5">0,00 €</span>
                                <input type="hidden" name="total" id="input-total" value="0.00">
                            </div>
                        </div>
                    </div>

                    <!-- ACCIONES DEL FORMULARIO -->
                    <div class="d-flex justify-content-between gap-3">
                        <a href="<?php echo URL_ROOT; ?>/dispensario" class="btn btn-lg btn-outline-secondary px-4 fw-bold"><i class="bi bi-arrow-left-circle me-1"></i> Cancelar</a>
                        <button type="submit" class="btn btn-lg btn-success px-5 fw-bold shadow-sm"><i class="fas fa-check-circle me-1"></i> Surtir Existencias</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- MOTOR INTERACTIVO DE LOGÍSTICA PARA CALCULO DINÁMICO EN EL MOSTRADOR -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectProducto = document.getElementById('producto_id');
        const inputPcm = document.getElementById('pcm');
        const inputUnidades = document.getElementById('unidades');
        const selectIva = document.getElementById('iva');
        const labelMedida = document.getElementById('label-medida');
        const badgeMedida = document.getElementById('badge-medida');

        const txtSubtotal = document.getElementById('txt-subtotal');
        const txtTotal = document.getElementById('txt-total');
        const inputSubtotal = document.getElementById('input-subtotal');
        const inputTotal = document.getElementById('input-total');

        // 1. Adapta la visualización si el producto es a Granel (gr) o Unidades (ud)
        if (selectProducto) {
            selectProducto.addEventListener('change', function() {
                const opcionActiva = this.options[this.selectedIndex];
                const servicioId = parseInt(opcionActiva.getAttribute('data-servicio') || 2);

                if (servicioId === 1) { // Granel
                    labelMedida.textContent = "Gramos a ingresar *";
                    badgeMedida.textContent = "g";
                    inputUnidades.step = "0.01";
                } else { // Unidades
                    labelMedida.textContent = "Unidades a ingresar *";
                    badgeMedida.textContent = "ud";
                    inputUnidades.step = "1";
                    if (inputUnidades.value) inputUnidades.value = Math.floor(inputUnidades.value);
                }
                calcularTotalesAlbaran();
            });
        }

        // 2. Escuchadores para calcular importes contables en vivo
        [inputPcm, inputUnidades, selectIva].forEach(element => {
            if (element) element.addEventListener('input', calcularTotalesAlbaran);
            if (element) element.addEventListener('change', calcularTotalesAlbaran);
        });

        // Añade la referencia al nuevo input del margen al inicio del script:
        const inputMargen = document.getElementById('margen');
        const txtPvpSugerido = document.getElementById('txt-pvp-sugerido');
        const inputPvpSugerido = document.getElementById('input-pvp-sugerido');

        // Incluye inputMargen dentro del array de escuchadores .forEach para que recalcule en vivo
        [inputPcm, inputUnidades, selectIva, inputMargen].forEach(element => {
            if (element) element.addEventListener('input', calcularTotalesAlbaran);
        });
        // Registramos el input del PVP en la cabecera de tus selectores:
        const inputPvp = document.getElementById('input-pvp');
        let pvpModificadoManualmente = false; // Bandera de control

        // Escuchamos si el operador decide escribir a mano en la casilla del PVP
        if (inputPvp) {
            inputPvp.addEventListener('input', function() {
                pvpModificadoManualmente = true; // El operador toma el control manual
            });
        }

        // Al cambiar de producto en el selector, reseteamos la bandera por si el nuevo artículo requiere recalcular
        if (selectProducto) {
            selectProducto.addEventListener('change', function() {
                pvpModificadoManualmente = false;
                // ... Tu lógica de gr/ud se queda igual ...
                calcularTotalesAlbaran();
            });
        }

    function calcularTotalesAlbaran() {
        const pcm      = parseFloat(inputPcm.value || 0);
        const unidades = parseFloat(inputUnidades.value || 0);
        const porcIva  = parseFloat(selectIva.value || 0);
        const margen   = parseFloat(inputMargen.value || 0);

        // 1. Cálculos de Albarán de Compra
        const subtotal = pcm * unidades;
        const total    = subtotal * (1 + (porcIva / 100));

        // Renderizamos las etiquetas visuales para el operario (con comas de visualización)
        txtSubtotal.textContent = subtotal.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
        txtTotal.textContent    = total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';

        // 🌟 CORRECCIÓN CONTABLE: Aseguramos que al POST viajen números puros sin formateos regionales
        inputSubtotal.value = subtotal.toFixed(2); // Guarda ej: "36.00"
        inputTotal.value    = total.toFixed(2);    // Guarda ej: "43.56"
        
        // El PVP sugerido editable se queda igual
        if (!pvpModificadoManualmente) {
            const costeConMargen = pcm * (1 + (margen / 100));
            const pvpSugerido = costeConMargen * (1 + (porcIva / 100));
            inputPvp.value = pvpSugerido.toFixed(2);
        }
    }


    });
</script>