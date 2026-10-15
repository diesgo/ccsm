(() => {
    const estado = document.getElementById('demo-actividad');
    if (!estado) return;
    let ultimaInteraccion = Date.now();
    let enCurso = false;
    let detenido = false;
    for (const evento of ['pointerdown', 'keydown', 'scroll']) {
        document.addEventListener(evento, () => { ultimaInteraccion = Date.now(); }, { passive: true });
    }
    setInterval(async () => {
        if (detenido || enCurso || document.hidden || Date.now() - ultimaInteraccion > 45000) return;
        enCurso = true;
        try {
            const respuesta = await fetch(estado.dataset.url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ csrf: estado.dataset.csrf })
            });
            if (!respuesta.ok || respuesta.redirected) throw new Error('Actividad no disponible');
            const datos = await respuesta.json();
            if (!datos.success) throw new Error('Actividad no registrada');
        } catch (error) {
            detenido = true;
            estado.textContent = 'No se pudo actualizar el análisis de actividad. Puedes seguir probando; recarga la página para reintentarlo.';
            estado.classList.remove('d-none');
        } finally {
            enCurso = false;
        }
    }, 30000);
})();
