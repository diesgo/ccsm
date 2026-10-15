/* ====================================================================
   GREENPOWER CCSM - TERMINAL TPV - MOTOR TRANSACCIONAL DE MOSTRADOR
   ==================================================================== */

// Variables globales de estado en la memoria de la sesión activa
let carrito = [];
let saldoSocioActivo = 0;

// Captura de nodos estructurales del DOM
let inputBuscarSocio, cajaSugerencias, inputOcultoSocio, btnLimpiarSocio;
let txtTotalCarrito, btnCobrar, contenedorCarrito, inputBuscarProducto;
let btnGuardarRecarga, inputMontoRecarga;

document.addEventListener('DOMContentLoaded', function() {
    // Inicialización de selectores nativos
    inputBuscarSocio     = document.getElementById('buscar-socio');
    cajaSugerencias      = document.getElementById('sugerencias-socios');
    inputOcultoSocio     = document.getElementById('select-socio');
    btnLimpiarSocio      = document.getElementById('btn-limpiar-socio');
    txtTotalCarrito      = document.getElementById('txt-total-carrito');
    btnCobrar            = document.getElementById('btn-cobrar');
    contenedorCarrito    = document.getElementById('contenedor-carrito');
    inputBuscarProducto  = document.getElementById('buscar-producto');
    btnGuardarRecarga    = document.getElementById('btn-guardar-recarga');
    inputMontoRecarga    = document.getElementById('input-monto');

    // Arranque de escuchadores perimetrales
    inicializarBuscadorSocio();
    inicializarBuscadorProductos();
    inicializarAgregarArticulos();
    inicializarModuloRecarga();
    inicializarBotonCobro();
});

/**
 * CONTROLADOR A: BUSCADOR PREDICTIVO E HISTORIAL DE SOCIOS
 */
function inicializarBuscadorSocio() {
    if (!inputBuscarSocio) return;

    inputBuscarSocio.addEventListener('input', function() {
        const cadena = this.value.toLowerCase().trim();
        if (cadena === '') {
            cajaSugerencias.classList.add('d-none');
            return;
        }

        // 'bancoDatosSocios' es la matriz inyectada en el DOM de la vista
        if (typeof bancoDatosSocios === 'undefined') return;

        const coincidencias = bancoDatosSocios.filter(s => s.search.includes(cadena));
        if (coincidencias.length === 0) {
            cajaSugerencias.innerHTML = `<div class="list-group-item text-muted small p-2 bg-white border"><i class="bi bi-person-x-fill me-2"></i>Ningún socio coincide</div>`;
            cajaSugerencias.classList.remove('d-none');
            return;
        }

        let rowsHTML = '';
        coincidencias.forEach(socio => {
            rowsHTML += `<button type="button" class="list-group-item list-group-item-action text-start btn-seleccionar-sug fw-bold text-dark py-2 px-3 bg-white d-flex align-items-center gap-2" data-id="${socio.id}" data-nombre="${socio.nombre}"><i class="bi bi-person-badge text-success"></i> ${socio.nombre}</button>`;
        });
        cajaSugerencias.innerHTML = rowsHTML;
        cajaSugerencias.classList.remove('d-none');

        document.querySelectorAll('.btn-seleccionar-sug').forEach(btn => {
            btn.addEventListener('click', function() {
                inputBuscarSocio.value = this.getAttribute('data-nombre');
                inputOcultoSocio.value = this.getAttribute('data-id');
                inputBuscarSocio.readOnly = true;
                cajaSugerencias.classList.add('d-none');
                cargarFichaSocioAsincrona(this.getAttribute('data-id'));
            });
        });
    });

    if (btnLimpiarSocio) {
        btnLimpiarSocio.addEventListener('click', function() {
            inputBuscarSocio.value = '';
            inputOcultoSocio.value = '';
            inputBuscarSocio.readOnly = false;

            const primeraTab = new bootstrap.Tab(document.getElementById('tab-operacion-link'));
            if (primeraTab) primeraTab.show();

            document.getElementById('ficha-socio').classList.add('d-none');
            saldoSocioActivo = 0;
            carrito = [];
            renderCarrito();
            inputBuscarSocio.focus();
        });
    }
}

function cargarFichaSocioAsincrona(idSocio) {
    if (!idSocio) return;

    fetch(window.ENV_URL_ROOT + '/dispensario/socio?id=' + idSocio)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const s = data.socio;
                const h = data.historial;
                saldoSocioActivo = parseFloat(s.saldo || 0);

                document.getElementById('socio-nombre').textContent = s.nombre + ' ' + (s.apellidos || '');
                document.getElementById('socio-dni').textContent = s.card_id || 'No aportado';
                document.getElementById('socio-consumo').textContent = parseFloat(s.consumo || 0).toLocaleString('es-ES', { minimumFractionDigits: 2 }) + ' g';

                const txtSaldo = document.getElementById('txt-saldo-socio');
                txtSaldo.textContent = saldoSocioActivo.toLocaleString('es-ES', { minimumFractionDigits: 2 }) + ' €';
                txtSaldo.className = saldoSocioActivo > 0 ? 'fw-bold text-success' : 'fw-bold text-danger';

                const avatar = document.getElementById('socio-avatar');
                if (s.imagen_perfil) {
                    avatar.innerHTML = '<img class="img-fluid h-100 w-100 img-ampliable" title="Ampliar foto" style="object-fit:cover;">';
                    avatar.querySelector('img').src = s.imagen_perfil_url;
                    avatar.querySelector('img').alt = s.nombre;
                } else {
                    avatar.innerHTML = s.nombre.substring(0, 1).toUpperCase();
                }

                const spanNac = document.getElementById('socio-nacimiento');
                const badgeCumple = document.getElementById('socio-cumple');
                const m = /^(\d{4})-(\d{2})-(\d{2})/.exec(s.birth || '');
                badgeCumple.classList.add('d-none');
                spanNac.parentElement.classList.remove('bg-warning-subtle', 'border', 'border-warning', 'rounded', 'px-2', 'py-1');
                if (m && m[1] !== '0000') {
                    const [, anio, mes, dia] = m.map(Number);
                    const hoy = new Date();
                    let edad = hoy.getFullYear() - anio;
                    const aunNoCumplido = (hoy.getMonth() + 1) < mes || ((hoy.getMonth() + 1) === mes && hoy.getDate() < dia);
                    if (aunNoCumplido) edad--;
                    spanNac.textContent = String(dia).padStart(2, '0') + '/' + String(mes).padStart(2, '0') + '/' + anio + ' (' + edad + ' años)';
                    // Quien nació un 29 de febrero celebra el 28 en los años no bisiestos
                    const bisiesto = (hoy.getFullYear() % 4 === 0 && hoy.getFullYear() % 100 !== 0) || hoy.getFullYear() % 400 === 0;
                    const diaCumple = (mes === 2 && dia === 29 && !bisiesto) ? 28 : dia;
                    if ((hoy.getMonth() + 1) === mes && hoy.getDate() === diaCumple) {
                        badgeCumple.classList.remove('d-none');
                        spanNac.parentElement.classList.add('bg-warning-subtle', 'border', 'border-warning', 'rounded', 'px-2', 'py-1');
                    }
                } else {
                    spanNac.textContent = 'No aportada';
                }

                const contDocs = document.getElementById('socio-documentos');
                let hayDocs = false;
                [['socio-id-front', s.idFront_url], ['socio-id-back', s.idBack_url]].forEach(([idImg, archivo]) => {
                    const img = document.getElementById(idImg);
                    img.classList.toggle('d-none', !archivo);
                    img.parentElement.classList.toggle('d-none', !archivo);
                    if (archivo) {
                        img.src = archivo;
                        hayDocs = true;
                    }
                });
                contDocs.classList.toggle('d-none', !hayDocs);

                const divExtracto = document.getElementById('tabla-extracto-socio');
                if (!h || h.length === 0) {
                    divExtracto.innerHTML = `<div class="text-muted py-3 text-center" style="font-size:11px;"><i class="bi bi-info-circle me-1"></i>Este miembro no registra ninguna extracción en su historial de cuenta.</div>`;
                } else {
                    let rowsHTML = `<div style="max-height: 250px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0 bg-transparent text-center align-middle" style="font-size:11px;">
                                      <thead class="text-muted border-bottom sticky-top bg-light" style="top:0; z-index:10;">
                                        <tr>
                                            <th class="text-start py-2">Fecha / Hora</th>
                                            <th class="text-start py-2">Producto</th>
                                            <th>Cant.</th>
                                            <th class="text-end">Costo</th>
                                            <th>Acción</th>
                                        </tr>
                                      </thead>
                                      <tbody>`;
                    h.forEach(v => {
                        const fechaCompleta = v.date_add_venta.substring(8, 10) + '/' + v.date_add_venta.substring(5, 7) + '/' + v.date_add_venta.substring(0, 4);
                        const horaCompleta = v.date_add_venta.substring(11, 19);
                        const sufijoMedida = (parseInt(v.servicio_id) === 1) ? 'g' : 'ud';

                        rowsHTML += `<tr>
                            <td class="font-monospace text-muted text-start" style="white-space:nowrap;">${fechaCompleta} <span class="text-xs text-secondary opacity-75">${horaCompleta}</span></td>
                            <td class="fw-bold text-dark text-start text-truncate" style="max-width: 120px;">${v.producto}</td>
                            <td class="font-monospace fw-bold text-secondary">${parseFloat(v.cantidad).toFixed(2)} <small class="text-muted fw-normal">${sufijoMedida}</small></td>
                            <td class="text-end font-monospace fw-bold text-danger">-${parseFloat(v.importe_total || v.total || 0).toFixed(2)} €</td>
                            <td>
                                <a href="${window.ENV_URL_ROOT}/dispensario/anular?id=${v.id_venta}" 
                                   class="btn btn-link text-danger p-0 m-0 border-0" 
                                   onclick="return confirm('¿Seguro que deseas anular definitivamente esta línea histórica?');">
                                    <i class="bi bi-trash-fill" style="font-size:12px;"></i>
                                </a>
                            </td>
                        </tr>`;
                    });
                    rowsHTML += `</tbody></table></div>`;
                    divExtracto.innerHTML = rowsHTML;
                }

                const elementoFicha = document.getElementById('ficha-socio');
                if (elementoFicha) elementoFicha.classList.remove('d-none');

                evaluarEstadoBoton();
            }
        });
}

/**
 * CONTROLADOR B: FILTRADO DE CATÁLOGO DE PRODUCTOS
 *//**
 * CONTROLADOR B: FILTRADO DE CATÁLOGO DE PRODUCTOS
 */
function inicializarBuscadorProductos() {
    if (inputBuscarProducto) {
        inputBuscarProducto.addEventListener('input', filtrarProductosMatriz);
    }

    document.querySelectorAll('.btn-filtro-cat, .btn-tpv-cat').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-filtro-cat, .btn-tpv-cat').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filtrarProductosMatriz();
        });
    });
}

function filtrarProductosMatriz() {
    const txt = inputBuscarProducto ? inputBuscarProducto.value.toLowerCase().trim() : '';
    const btnActivo = document.querySelector('.btn-tpv-cat.active, .btn-filtro-cat.active');
    const catId = btnActivo ? btnActivo.getAttribute('data-cat-id') : 'todos';

    document.querySelectorAll('.item-producto-tpv').forEach(col => {
        const itemCatId = col.getAttribute('data-categoria-id');
        const card = col.querySelector('.card');
        const name = card ? card.getAttribute('data-nombre').toLowerCase() : '';
        if ((catId === 'todos' || itemCatId === catId) && name.includes(txt)) {
            col.classList.remove('d-none');
        } else {
            col.classList.add('d-none');
        }
    });
}

/**
 * CONTROLADOR C: INTERACCIÓN Y RENDERIZACIÓN DE LA CESTA DE COMPRA
 */
function inicializarAgregarArticulos() {
    document.querySelectorAll('.btn-agregar').forEach(card => {
        card.addEventListener('click', function() {
            const stock = parseFloat(this.getAttribute('data-stock') || 0);
            if (stock <= 0 || !inputOcultoSocio.value) return;

            const id = parseInt(this.getAttribute('data-id'));
            const servicioId = parseInt(this.getAttribute('data-servicio-id') || 2);

            let existente = carrito.find(i => i.id === id);
            if (existente) {
                if (existente.cantidad + 1 <= stock) {
                    existente.cantidad += 1;
                    existente.total = existente.cantidad * existente.precio;
                } else {
                    alert('Existencias insuficientes en el mostrador.');
                }
            } else {
                carrito.push({
                    id,
                    nombre: this.getAttribute('data-nombre'),
                    precio: parseFloat(this.getAttribute('data-precio')),
                    stock,
                    servicioId,
                    cantidad: 1,
                    total: parseFloat(this.getAttribute('data-precio'))
                });
            }
            renderCarrito();
        });
    });
}

function renderCarrito() {
    if (!contenedorCarrito) return;

    if (carrito.length === 0) {
        contenedorCarrito.innerHTML = `<p class="text-muted text-center py-4 my-0 small"><i class="bi bi-receipt d-block display-6 mb-2 text-secondary"></i>La cesta está vacía.</p>`;
        txtTotalCarrito.textContent = '0,00 €';
        evaluarEstadoBoton();
        return;
    }

    let htmlRows = '';
    let totalGeneral = 0;

    carrito.forEach((item, index) => {
        totalGeneral += item.total;
        let inputsBloqueHTML = '';

        if (item.servicioId === 1) { // MÓDULO AL PESO / GRANEL: Entrada Dual Unificada en Paralelo
            inputsBloqueHTML = `
            <div class="input-group input-group-sm shadow-sm">
                <input type="number" class="form-control text-center input-cantidad-dual font-monospace fw-bold text-dark" 
                       id="input-gr-${index}" data-index="${index}" data-tipo="gramos"
                       value="${item.cantidad.toFixed(2)}" step="0.01" min="0.01" max="${item.stock}" placeholder="gr">
                <span class="input-group-text bg-light fw-bold text-secondary" style="font-size:11px;">gr</span>
                
                <input type="number" class="form-control text-center input-cantidad-dual font-monospace fw-bold text-success" 
                       id="input-eur-${index}" data-index="${index}" data-tipo="euros"
                       value="${item.total.toFixed(2)}" step="0.50" min="0.05" placeholder="€">
                <span class="input-group-text bg-light fw-bold text-success" style="font-size:11px;">€</span>
            </div>`;
        } else { // MÓDULO POR UNIDADES ESTRICTAS (Bebidas, Snacks)
            inputsBloqueHTML = `
            <div class="input-group input-group-sm shadow-sm">
                <input type="number" class="form-control text-center input-cantidad-fila font-monospace fw-bold text-dark" 
                       value="${Math.floor(item.cantidad)}" data-index="${index}" step="1" min="1" max="${Math.floor(item.stock)}">
                <span class="input-group-text bg-light small fw-semibold" style="font-size:11px;">ud</span>
            </div>`;
        }

        let infoTarifaTexto = (item.servicioId === 1) ?
            `<i class="bi bi-info-circle me-1"></i>Tarifa: <strong class="text-dark">${item.precio.toFixed(2)} € / g</strong> (Stock: ${item.stock.toFixed(1)}g)` :
            `<i class="bi bi-info-circle me-1"></i>Precio: <strong class="text-dark">${item.precio.toFixed(2)} € / ud</strong> (Stock: ${Math.floor(item.stock)}ud)`;

        htmlRows += `
        <div class="p-3 bg-white mb-2 border rounded rounded-3 shadow-sm position-relative">
            <button type="button" class="btn position-absolute top-0 end-0 p-1.5 text-muted btn-borrar-fila" data-index="${index}"><i class="bi bi-x-lg" style="font-size:10px;"></i></button>
            <div class="fw-bold text-dark text-truncate small mb-2"><i class="bi bi-bag-check text-secondary me-1"></i>${item.nombre}</div>
            <div class="mb-2">${inputsBloqueHTML}</div>
            <div class="text-muted d-flex justify-content-between align-items-center pt-1" style="font-size:10px;">
                <span>${infoTarifaTexto}</span>
                <span class="font-monospace fw-bold text-dark bg-light px-2 py-0.5 rounded" style="font-size:11px;">Subtotal: ${item.total.toLocaleString('es-ES', {minimumFractionDigits:2, maximumFractionDigits:2})} €</span>
            </div>
        </div>`;
    });

    contenedorCarrito.innerHTML = htmlRows;
    txtTotalCarrito.textContent = totalGeneral.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';

    vincularEscuchadoresInternosCesta();
    evaluarEstadoBoton();
}

function vincularEscuchadoresInternosCesta() {
    // 1. Botón eliminar línea
    document.querySelectorAll('.btn-borrar-fila').forEach(b => b.addEventListener('click', function() {
        carrito.splice(parseInt(this.getAttribute('data-index')), 1);
        renderCarrito();
    }));

    // 2. Conversión bidireccional en caliente (Granel)
    document.querySelectorAll('.input-cantidad-dual').forEach(input => {
        input.addEventListener('input', function() {
            const idx = parseInt(this.getAttribute('data-index'));
            const tipoEntrada = this.getAttribute('data-tipo');
            const valorIngresado = parseFloat(this.value || 0);
            const precioGramo = carrito[idx].precio;

            let inputGramos = document.getElementById(`input-gr-${idx}`);
            let inputEuros = document.getElementById(`input-eur-${idx}`);

            if (tipoEntrada === 'gramos') {
                let gramos = valorIngresado;
                if (gramos > carrito[idx].stock) {
                    alert('Límite de existencias: ' + carrito[idx].stock + ' g');
                    gramos = carrito[idx].stock;
                    this.value = gramos.toFixed(2);
                }
                let eurosCalculados = gramos * precioGramo;
                carrito[idx].cantidad = gramos;
                carrito[idx].total = eurosCalculados;
                if (inputEuros) inputEuros.value = eurosCalculados.toFixed(2);

            } else if (tipoEntrada === 'euros') {
                let euros = valorIngresado;
                let gramosCalculados = euros / precioGramo;
                if (gramosCalculados > carrito[idx].stock) {
                    alert('El importe supera el stock físico de mostrador.');
                    gramosCalculados = carrito[idx].stock;
                    euros = gramosCalculados * precioGramo;
                    this.value = euros.toFixed(2);
                }
                carrito[idx].cantidad = gramosCalculados;
                carrito[idx].total = euros;
                if (inputGramos) inputGramos.value = gramosCalculados.toFixed(2);
            }

            gtWithoutPaint();

            const subtotalBadge = this.closest('.p-3').querySelector('.font-monospace');
            if (subtotalBadge) {
                subtotalBadge.textContent = 'Subtotal: ' + carrito[idx].total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
            }
        });
    });

        // 3. Ajustes por unidades enteras
    document.querySelectorAll('.input-cantidad-fila').forEach(input => {
        input.addEventListener('input', function() {
            const idx = parseInt(this.getAttribute('data-index'));
            let cant = Math.floor(parseFloat(this.value || 0));

            if (cant < 1) cant = 1;
            this.value = cant;

            if (cant > carrito[idx].stock) {
                alert('Límite de unidades: ' + Math.floor(carrito[idx].stock));
                cant = Math.floor(carrito[idx].stock);
                this.value = cant;
            }

            carrito[idx].cantidad = cant;
            carrito[idx].total = cant * carrito[idx].precio;

            gtWithoutPaint();

            const subtotalBadge = this.closest('.p-3').querySelector('.font-monospace');
            if (subtotalBadge) {
                subtotalBadge.textContent = 'Subtotal: ' + carrito[idx].total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
            }
        });
    });
}

function gtWithoutPaint() {
    let gt = 0;
    carrito.forEach(item => { gt += item.total; });
    txtTotalCarrito.textContent = gt.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
    evaluarEstadoBoton();
}

function evaluarEstadoBoton() {
    if (!btnCobrar) return;
    const idSocioVerificado = inputOcultoSocio ? inputOcultoSocio.value : '';
    if (carrito.length === 0 || !idSocioVerificado) {
        btnCobrar.disabled = true;
        return;
    }

    let totalGeneralCesta = 0;
    carrito.forEach(i => totalGeneralCesta += i.total);

    btnCobrar.disabled = (totalGeneralCesta > saldoSocioActivo);
    btnCobrar.classList.replace(
        totalGeneralCesta > saldoSocioActivo ? 'btn-success' : 'btn-danger',
        totalGeneralCesta > saldoSocioActivo ? 'btn-danger' : 'btn-success'
    );
}

/**
 * CONTROLADOR D: ENTRADA ASÍNCRONA (AJAX) DE RECARGA DE SALDO
 */
function inicializarModuloRecarga() {
    // Escuchador de los botones rápidos de incremento (+10€, +20€, +50€)
    document.querySelectorAll('.btn-fast').forEach(btn => {
        btn.addEventListener('click', function() {
            if (inputMontoRecarga) {
                let actual = parseFloat(inputMontoRecarga.value || 0);
                let incremento = parseFloat(this.getAttribute('data-val') || 0);
                inputMontoRecarga.value = actual + incremento;
            }
        });
    });

    if (btnGuardarRecarga) {
        btnGuardarRecarga.addEventListener('click', function() {
            const idSocioReal = inputOcultoSocio.value;
            const monto = parseFloat(inputMontoRecarga ? inputMontoRecarga.value : 0);

            if (!idSocioReal) {
                alert('Atención: Debe seleccionar primero un socio operativo en el mostrador.');
                return;
            }

            if (isNaN(monto) || monto <= 0) {
                alert('Por favor, introduzca un importe de recarga superior a 0 €.');
                return;
            }

            btnGuardarRecarga.disabled = true;
            btnGuardarRecarga.innerHTML = `<i class="bi bi-arrow-repeat spin-animation me-1"></i> Procesando...`;

            const datosFormulario = new FormData();
            datosFormulario.append('id_socio', idSocioReal);
            datosFormulario.append('monto', monto);

            fetch(window.ENV_URL_ROOT + '/dispensario/recargar', {
                method: 'POST',
                body: datosFormulario
            })
            .then(res => {
                if (!res.ok) throw new Error('Fallo de red en Apache.');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    saldoSocioActivo = parseFloat(data.nuevo_saldo);

                    const txtSaldoSocio = document.getElementById('txt-saldo-socio');
                    if (txtSaldoSocio) {
                        txtSaldoSocio.textContent = saldoSocioActivo.toLocaleString('es-ES', { minimumFractionDigits: 2 }) + ' €';
                        txtSaldoSocio.className = 'fw-bold text-success';
                    }

                    const modalRecargaElement = document.getElementById('modalRecarga');
                    const instanciaModal = bootstrap.Modal.getInstance(modalRecargaElement);
                    if (instanciaModal) instanciaModal.hide();

                    evaluarEstadoBoton();
                } else {
                    alert('Conflicto: ' + data.message);
                }
            })
            .catch(error => {
                console.error("Error en la recarga:", error);
                window.location.reload();
            })
            .finally(() => {
                btnGuardarRecarga.disabled = false;
                btnGuardarRecarga.innerHTML = `<i class="fas fa-check-circle me-1"></i> Confirmar Recarga`;
                if (inputMontoRecarga) inputMontoRecarga.value = '100';
            });
        });
    }
}

/**
 * CONTROLADOR E: DESPACHO SECUENCIAL ASÍNCRONO DE LA CESTA
 */
function inicializarBotonCobro() {
    if (!btnCobrar) return;

    btnCobrar.addEventListener('click', function() {
        const idSocioReal = inputOcultoSocio.value;
        if (carrito.length === 0 || !idSocioReal) {
            alert('Atención: Debe seleccionar un socio operativo con ficha válida.');
            return;
        }

        btnCobrar.disabled = true;
        btnCobrar.innerHTML = `<i class="bi bi-arrow-repeat spin-animation me-1"></i> Procesando Transacción...`;

        let promesas = carrito.map(item => {
            const formData = new FormData();
            formData.append('id_socio', idSocioReal);
            formData.append('id_producto', item.id);
            formData.append('cantidad', item.cantidad);
            formData.append('total', item.total);

            return fetch(window.ENV_URL_ROOT + '/dispensario/cobrar', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) return res.text().then(text => { throw new Error(text) });
                return res.json();
            });
        });

        Promise.all(promesas)
            .then(resultados => {
                if (resultados.every(r => r.success === true)) {
                    alert('¡Dispensación multilineal procesada con éxito!');
                    window.location.reload();
                } else {
                    let fallosContables = resultados.filter(r => !r.success).map(r => r.message).join('\n');
                    alert('Conflictos en el cierre de caja:\n' + fallosContables);
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error("Error crítico del mostrador:", error);
                alert("Fallo crítico en el servidor de base de datos.");
                btnCobrar.disabled = false;
                btnCobrar.innerHTML = `<i class="fas fa-cash-register me-1"></i> Confirmar Retirada`;
            });
    });
}

/**
 * CONTROLADOR F: AMPLIAR IMÁGENES (productos y foto del socio, incluidas las cargadas dinámicamente)
 */
document.addEventListener('click', function (e) {
    const img = e.target.closest('.img-ampliable');
    const modalEl = document.getElementById('modalImagenProducto');
    if (!img || !modalEl) return;

    e.stopPropagation();
    document.getElementById('modalImagenSrc').src = img.currentSrc || img.src;
    document.getElementById('modalImagenSrc').alt = img.alt;
    document.getElementById('modalImagenTitulo').textContent = img.alt;
    bootstrap.Modal.getOrCreateInstance(modalEl).show();
}, true);
