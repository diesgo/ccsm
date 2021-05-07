 <!DOCTYPE html>
 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title><?php echo $titulo ?> | CCSM</title>
     <link rel="icon" href="/club/img/ccms.ico" type="image/gif" sizes="16x16">
     <link rel="stylesheet" href="/club/css/w3.css">
     <link rel="stylesheet" href="/club/css/w3-theme-<?php
                                                        $servername = "localhost";
                                                        $username = "root";
                                                        $password = "";
                                                        $dbname = "greenpower";
                                                        // Create connection
                                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                                        // Check connection
                                                        if ($conn->connect_error) {
                                                            die("Connection failed: " . $conn->connect_error);
                                                        }
                                                        $sql = "SELECT color, fuente, titulos FROM settings";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['color'];
                                                        }
                                                        $conn->close();
                                                        ?>.css">
     <link rel="stylesheet" href="/club/webfonts/stylesheet.css">
     <link rel="stylesheet" href="/club/fontawesome5/css/all.css">
     <link rel="stylesheet" href="/club/css/style.css">
 </head>
 <style>
     .panel {
         box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
     }

     h1,
     h2,
     h3,
     h4,
     h5,
     h6 {
         font-family: <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "greenpower";
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT *  FROM settings";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo $row['titulos'];
                        }
                        $conn->close();
                        ?>;
     }
 </style>

 <body class="w3-theme-light font-<?php
                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $dbname = "greenpower";
                                    // Create connection
                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    $sql = "SELECT * FROM settings";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        echo $row['fuente'];
                                    }
                                    $conn->close();
                                    ?>">

     <!-- Top container -->

     <div class="w3-bar w3-top w3-theme w3-large panel" style="z-index:4; padding: 2px 32px">
         <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-theme" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
         <a class="w3-bar-item w3-button w3-round w3-theme-d3 w3-hover-theme" href="../../dispensario/index.php">Dispensario</a>
         <span class="w3-bar-item w3-right"><img class="w3-image" src="/club/img/logo_negro.png" alt="logo" style="max-width:24px"></span>
     </div>

     <!-- Sidebar/menu -->

     <nav class="w3-sidebar w3-collapse w3-theme-d3 panel" style="z-index:3;width:300px;" id="mySidebar"><br>

         <div class="w3-container w3-theme-d3 panel">
             <h5 class="w3-text-white"><i class="fas fa-tachometer-alt"></i> Panel de control</h5>
         </div>

         <div class="w3-bar-block">
             <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-theme" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>
             <a href="/club/admin/home/index.php" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fas fa-home"></i> Home</a>
             <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-hover-theme" onclick="dropAside('catalogo')"><i class="fas fa-boxes"></i> Stock <i class="w3-right fa fa-caret-down"></i></button>
             <div id="catalogo" class="w3-hide w3-white w3-theme-l2">
                 <a href="/club/admin/categorias/index.php" class="w3-bar-item w3-button w3-hover-theme">Categorias</a>
                 <a href="/club/admin/productos/index.php" class="w3-bar-item w3-button w3-hover-theme">Productos</a>
             </div>
             <button class="w3-button w3-block w3-left-align w3-theme-l1 w3-hover-theme" onclick="dropAside('configuracion')"><i class="fa fa-cog fa-fw"></i> Configuración <i class="w3-right fa fa-caret-down"></i></button>
             <div id="configuracion" class="w3-hide w3-white w3-theme-l2">
                 <a href="/club/admin/roles/index.php" class="w3-bar-item w3-button w3-hover-theme">Roles</a>
                 <a href="#" class="w3-bar-item w3-button w3-hover-theme">Tarifas</a>
             </div>
             <div class="w3-bar-block">
                 <a href="/club/admin/socios/index.php" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fa fa-users a-fw"></i> Socios</a>
                 <a href="#" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fas fa-chart-line"></i> Statistics</a>
                 <a href="#" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fas fa-gem"></i> Orders</a>
                 <a href="#" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fa fa-bell fa-fw"></i> News</a>
                 <a href="#" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fas fa-university"></i> General</a>
                 <a href="#" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fa fa-history fa-fw"></i> History</a>
                 <a href="/club/admin/setings/index.php" class="w3-bar-item w3-button w3-padding w3-theme-l1 w3-hover-theme"><i class="fas fa-sliders-h"></i> Ajustes</a><br><br>
             </div>
         </div>
     </nav>

     <!-- Overlay effect when opening sidebar on small screens -->

     <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

     <script src="/club/admin/js/header.js"></script>

     <div class="w3-main" style="margin-left:300px;margin-top:43px; min-height: max-content;">