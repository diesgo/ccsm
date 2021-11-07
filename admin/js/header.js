function dropAside(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-green";
    } else {
        x.className = x.className.replace(" w3-show", "");
        x.previousElementSibling.className =
            x.previousElementSibling.className.replace(" w3-green", "");
    }
}

function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        // overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        // overlayBg.style.display = "block";
    }
}

function w3_close() {
    mySidebar.style.display = "none";
    // overlayBg.style.display = "none";
}

function estadoStock() {
    var cantidad = document.getElementsByClassName('estado');
    var i = cantidad.length;
    for (let z = 0; z < i; z++) {
        var element = parseFloat(cantidad[z].innerHTML);
        if (element === 0) {
            cantidad[z].classList.add("w3-text-red");
        } else if (element < 0.4) {
            cantidad[z].classList.add("w3-text-orange");
        } else {
            cantidad[z].classList.add("w3-text-green");
        }
    }
}

function service() {
    var text;
    var serv = altaProducto.servicio.value;
    var setCup = document.getElementById('setCup');
    var vari = document.getElementById('vari');
    switch (serv) {
        case "":
            setCup.classList.add('w3-hide');
            vari.classList.add('w3-hide');
            break;
        case "granel":
            setCup.classList.remove('w3-hide');
            vari.classList.remove('w3-hide');
            break;
        case "unidad":
            setCup.classList.add('w3-hide');
            vari.classList.add('w3-hide');
            break;
        default:
            text = "I have never heard of that fruit...";
    };
}

function variedad() {
    var text;
    var serv = altaProducto.disp.value;
    switch (serv) {
        case "":
            setCup.classList.add('w3-hide');
            vari.classList.add('w3-hide');
            break;
        case "granel":
            setCup.classList.remove('w3-hide');
            vari.classList.remove('w3-hide');
            break;
        case "unidad":
            setCup.classList.add('w3-hide');
            vari.classList.add('w3-hide');
            break;
        default:
            text = "I have never heard of that fruit...";
    };
}