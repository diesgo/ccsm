const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');

(async () => {
    let ahora = 0;
    let peticiones = 0;
    let intervalo;
    let respuestaCorrecta = true;
    const eventos = {};
    const estado = { dataset: { url: '/demo/actividad', csrf: 'token' }, classList: { remove() {} } };
    const documento = {
        hidden: false,
        getElementById: () => estado,
        addEventListener: (tipo, handler) => { eventos[tipo] = handler; }
    };
    const contexto = {
        document: documento, Date: { now: () => ahora }, URLSearchParams,
        setInterval: (handler, ms) => { intervalo = handler; assert.equal(ms, 30000); },
        fetch: async (_url, opciones) => {
            peticiones++;
            assert.equal(opciones.body.toString(), 'csrf=token');
            return { ok: respuestaCorrecta, redirected: false, json: async () => ({ success: true }) };
        }
    };
    vm.runInNewContext(fs.readFileSync(path.join(__dirname, '../public/js/demo-actividad.js'), 'utf8'), contexto);
    ahora = 30000;
    await intervalo();
    assert.equal(peticiones, 1);
    documento.hidden = true;
    await intervalo();
    assert.equal(peticiones, 1);
    documento.hidden = false;
    ahora = 45001;
    await intervalo();
    assert.equal(peticiones, 1);
    eventos.keydown();
    await intervalo();
    assert.equal(peticiones, 2);
    respuestaCorrecta = false;
    await intervalo();
    assert.equal(peticiones, 3);
    assert.match(estado.textContent, /No se pudo/);
    await intervalo();
    assert.equal(peticiones, 3);
    console.log('OK: señal cada 30 s, pausa oculta/inactiva, sin contenido y error visible.');
})().catch(error => { console.error(error); process.exitCode = 1; });
