function dropAside(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        // x.previousElementSibling.className += " w3-green";
    } else {
        x.className = x.className.replace(" w3-show", "");
        // x.previousElementSibling.className =
        //     x.previousElementSibling.className.replace(" w3-green", "");
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
        element.classList.add("invalid");
        return false;
    }else{
        element = document.getElementById(id);
        element.classList.add("invalid")
    }
}

function openNav() {
    document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}

function openTab(evt, tabNumber) {
    var i, x, tablinks;
    x = document.getElementsByClassName("tab");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-white w3-text-theme", "");
    }
    document.getElementById(tabNumber).style.display = "block";
    evt.currentTarget.className += " w3-white w3-text-theme";
}

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("grid");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}