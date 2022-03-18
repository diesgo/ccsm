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

function captarCheckbox() {
    var check = document.getElementsByClassName("activo");
    var checkLong = check.length;
    for (let i = 0; i < checkLong; i++) {
        if (check[i].value == 1) {
            check[i].setAttribute('checked', '');
        } else {
            check[i].removeAttribute('checked', '');
        }
    }
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
    var serv = form.servicio.value;
    // var setCup = document.getElementById('setCup');
    var vari = document.getElementById('vari');
    if (serv === "1") {
        // setCup.classList.remove('w3-hide');
        vari.classList.remove('w3-hide');
    } else {
        // setCup.classList.add('w3-hide');
        vari.classList.add('w3-hide');        
    }
}

function variedad() {
    var text;
    var serv = updateProduct.disp.value;
    switch (serv) {
        case "":
            tara.classList.add('w3-hide');
            vari.classList.add('w3-hide');
            break;
        case "1":
            tara.classList.remove('w3-hide');
            vari.classList.remove('w3-hide');
            break;
        case "2":
            tara.classList.add('w3-hide');
            vari.classList.add('w3-hide');
            break;
        default:
            text = "I have never heard of that fruit...";
    };
}

function searchTableByName() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("list");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function warningErase(){
    text = "Esta acción puede corromper la integridad de la Base de Datos causando daños irreparables. CCSM no se responsaviliza de los daños ocasonados.";
    if (confirm(text) == true) {
        text = "You pressed OK!";
    } else {
    location.reload();
    }
   
}

function checkName(id){
    var ptrnombre = /^[A-ZÀ]{1}[a-zA-ZÀ-ÿ\u00f1\u00d1\s]{1,20}$/;
    var name = document.getElementById(id).value;
    console.log(name);
    if (!ptrnombre.test(name)) {
        element = document.getElementById(id);
        element.classList.add("w3-border-red");
        return false;
    }
}