<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>CCSM | Dispensario</title>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <!-- <link rel="stylesheet" href="css/4.5.0/css/bootstrap.css"> -->

    <link rel="stylesheet" href="../fontawesome5/css/all.css">
    <link rel="stylesheet" href="../webfonts/stylesheet.css">
    <link rel="stylesheet" href="../css/specimen_stylesheet.css">
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../css/w3-theme-blue-grey.css">
    <link rel="stylesheet" href="../css/carrito.css">
    <link rel="stylesheet" href="../css/ccms.css">
</head>

<body class="w3-theme-light font-varela">

    <div class="w3-container">
        <div class="w3-cell-row">
            <div class="w3-cell w3-center"><button class="w3-green w3-hover-green w3-padding-button w3-button w3-border w3-round w3-border-green" onclick="renderItems()">default</button></div>
            <div class="w3-cell w3-center"><button class="w3-green w3-hover-green w3-padding-button w3-button w3-border w3-round w3-border-green" onclick="renderItems()">default</button></div>
            <div class="w3-cell w3-center"><button class="w3-green w3-hover-green w3-padding-button w3-button w3-border w3-round w3-border-green" onclick="">default</button></div>
        </div>
    </div>

    <div class="w3-container" id="disp">

    </div>

    <!-- Sidebar/menu -->

    <nav class="w3-sidebar w3-collapse w3-theme-l4" style="margin-left: 80%; width: 20%;" id="mySidebar"><br>
        <div class="w3-container w3-margin-bottom">
            <button class="w3-button w3-theme-gradient-dark w3-round w3-block w3-text-theme" onclick="openNav()"><i class="fas fa-bars"></i> Dispensar</button>
        </div>
        <div id="loginSocio" class="w3-container w3-margin-bottom">
            <input class="w3-input w3-border w3-round w3-theme-l5" type="password" name="chipNumber" autofocus="autofocus" id="chipNumber" onclick="openNav()" placeholder="&#128272;">
        </div>
        <div class="w3-container">
            <div class="w3-half w3-margin-bottom">
                <img class="w3-image" src="img/s/avatar11.png" alt="" width="100%">
            </div>
            <div class="w3-half w3-padding-tiny">
                <h6 style="margin: 0">Nº Socio: <span id="numberSocio">&#128286;</span></h6>
                <h6 style="margin: 0">Nombre: <span id="nameSocio">&#128274;</span></h6>
                <h6 style="margin: 0">Credito: <span id="cashSocio">&#128275;</span></h6>
                <h6 style="margin: 0" class="w3-margin-bottom">Notas <span id="noteSocio"></span></h6>
            </div>
        </div>

        <div class="w3-container">
            <h2>Carrito</h2>
            <!-- Elementos del carrito -->
            <table style="width: 100%;" id="carrito"></table>
            <hr>
            <!-- Precio total -->
            <p class="w3-right-align">Total: <span id="total"></span>&euro;</p>
            <button id="boton-vaciar" class="w3-button w3-round w3-block botonRojo">Vaciar carrito</button>
        </div>

        <!-- Teclado numérico -->

        <div class="w3-container w3-padding w3-green">
            <table class="w3-auto">
                <tr class="w3-center">
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="7" value="7" onclick="mostra('7');" />
                    </td>
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="8" value="8" onclick="mostra('8');" />
                    </td>
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="9" value="9" onclick="mostra('9');" />
                    </td>
                </tr>
                <tr class="w3-center">
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="4" value="4" onclick="mostra('4')" />
                    </td>
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="5" value="5" onclick="mostra('5');" />
                    </td>
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="6" value="6" onclick="mostra('6');" />
                    </td>
                </tr>
                <tr class="w3-center">
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="1" value="1" onclick="mostra('1');" />
                    </td>
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button w3-text-white" id="2" value="2" onclick="mostra('2');" />
                    </td>
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="3" value="3" onclick="mostra('3');" />
                    </td>
                </tr>
                <tr class="w3-center">
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="," value="," onclick="mostra('.')" />
                    </td>
                    <td class="w3-theme-gradient-dark w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="0" value="0" onclick="mostra('0');" />
                    </td>
                    <td class="botonRojo w3-padding-4 w3-border">
                        <input type="Button" class="w3-button" id="C" value="C" onclick="teclaC();" />
                    </td>
                </tr>
            </table>
        </div>
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->

    <div class="w3-container w3-block w3-theme-light" style="width: 80%; padding: 0px;">

        <div id="mySidepanel" class="sidepanel w3-theme-l2 w3-animate-left">
            <div class="w3-content">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fas fa-times"></i></a>
                <div class="w3-container" style="margin-top: 10%;">
                    <button class="dropdown-btn w3-button  w3-right-align w3-border w3-theme w3-padding-16" onclick="renderItems()"><i class="fa fa-caret-down"></i> Flores y derivados <i class="fa fa-caret-down"></i></button>
                    <div id="dropWeed" class="dropdown-container w3-theme-l3">
                        <a href="#tab01" class="w3-button  w3-right-align w3-border w3-theme-dark w3-padding-16" onclick="openTabCategory(event, 'tab01'); closeNav();drop('dropWeed')">Flores</a>
                        <a href="#tab02" class="w3-button  w3-right-align w3-border w3-theme-dark w3-padding-16" onclick="openTabCategory(event, 'tab02'); closeNav();drop('dropWeed')">Hash</a>
                        <a href="#tab03" class="w3-button  w3-right-align w3-border w3-theme-dark w3-padding-16" onclick="openTabCategory(event, 'tab03'); closeNav();drop('dropWeed')">Extractos</a>
                    </div>
                    <button class="dropdown-btn w3-button  w3-right-align w3-border w3-theme w3-padding-16" onclick="drop('dropBar')">BAR <i class="fa fa-caret-down"></i></button>
                    <div id="dropBar" class="dropdown-container w3-theme-l3">
                        <a href="#tab04" class="w3-button  w3-right-align w3-border w3-theme-dark w3-padding-16" onclick="openTabCategory(event, 'tab04'); closeNav();drop('dropBar')">Snacks</a>
                        <a href="#tab05" class="w3-button  w3-right-align w3-border w3-theme-dark w3-padding-16" onclick="openTabCategory(event, 'tab05'); closeNav();drop('dropBar')">Refrescos</a>
                        <a href="#tab06" class="w3-button  w3-right-align w3-border w3-theme-dark w3-padding-16" onclick="openTabCategory(event, 'tab06'); closeNav();drop('dropBar')">Café e Infusiones</a>
                    </div>
                    <a href="#tab07" class="w3-button w3-right-align w3-border w3-theme w3-padding-16 w3-margin-bottom">Parafernalia</a>
                    <a href="#">Clients</a>
                    <a href="#">Contact</a>
                </div>


            </div>

            <!-- <button class="w3-button w3-theme" onclick="openNav()" style="position: fixed; top: 0;left: 25%;">☰</button> -->

        </div>
    </div>

    <div class="w3-container" style="width: 75%; padding: 0px">

        <!-- TAB 1 -->

        <div id="tab01" class="tabcontent">
            <div id="tab1" class="w3-row-padding"></div>
        </div>

        <!-- TAB 2 -->

        <div id="tab02" class="tabcontent">
            <div id="tab2" class="w3-row-padding"></div>
        </div>

        <!-- TAB 3 -->

        <div id="tab03" class="tabcontent">
            <div id="tab3" class="w3-row-padding"></div>
        </div>

        <!-- TAB 4 -->

        <div id="tab04" class="tabcontent">
            <div id="tab4" class="w3-row-padding"></div>
        </div>

        <!-- TAB 5 -->

        <div id="tab05" class="tabcontent">
            <div id="tab5" class="w3-row-padding"></div>
        </div>

        <!-- TAB 6 -->

        <div id="tab06" class="tabcontent">
            <div id="tab6" class="w3-row-padding"></div>
        </div>

        <!-- TAB 7 -->

        <div id="tab07" class="tabcontent">
            <div id="tab7" class="w3-row-padding"></div>
        </div>
    </div>
    <script src="../js/products.js"></script>
    <script src="../js/carrito1.js"></script>
    <script src="../admin/js/scripts.js"></script>

    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "80%";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        // var dropdown = document.getElementsByClassName("dropdown-btn");
        // var i;
        // for (i = 0; i < dropdown.length; i++) {
        //     dropdown[i].addEventListener("click", function() {
        //         this.classList.toggle("active");
        //         var dropdownContent = this.nextElementSibling;
        //         if (dropdownContent.style.display === "block") {
        //             dropdownContent.style.display = "none";
        //         } else {
        //             dropdownContent.style.display = "block";
        //         }
        //     });
        // } 

        function openTabCategory(evt, tabId) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" w3-opacity", "");
            }
            document.getElementById(tabId).style.display = "block";
            evt.currentTarget.className += " w3-opacity";
        }
    </script>

</body>

</html>