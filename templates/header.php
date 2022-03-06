<!DOCTYPE html>
<html lang="es">
    <?php
    require "../config.php";
    require "../config/functions.php";
    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $setting = getSetingsById(1 );
    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CCSM</title>
    <link rel="icon" href="img/ccms.ico" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="fontawesome5/css/all.css">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/themes/w3-theme-<?php echo $setting['color'];?>.css">
    <link rel="stylesheet" href="webfonts/stylesheet.css">
    
    <link rel="stylesheet" href="css/carrito.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    h1, h2, h3, h4, h5, h6 {
        font-family: <?php echo $setting['titulos'];?>;
    }
 </style>

 <body class="w3-theme-light font-<?php echo $setting['fuente']; ?>">
     <div id="pantalla">

         <!-- CABECERA -->

         <div class="w3-margin-top">
             <div class="w3-container w3-center">

                 <div class="w3-quarter">
                     <a href="index.php"><img src="../img/ccms_logo.png" alt="C C M S" class="w3-image" width="70"></a>
                 </div>

                 <div class="w3-half">
                     <h2 class="w3-text-theme w3-white w3-border w3-border-theme w3-round">Cannabis Club System Management</h2>
                     <div class="w3-cell-row">

                         <!-- DISPENSARIO -->

                         <div class="w3-cell w3-center w3-mobile">

                             <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="menu.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                 <i class="fas fa-store w3-xlarge"></i>
                                 <p class="w3-small" style="margin:0;">Menu</p>
                             </a>

                         </div>

                         <!-- ADMINISTRACIÓN -->

                         <div class="w3-cell w3-center w3-mobile">

                             <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="../admin/home/index.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                 <i class="fas fa-cogs w3-xlarge"></i>
                                 <p class="w3-small" style="margin:0;">Administración</p>
                             </a>

                         </div>

                         <div class="w3-cell w3-center w3-mobile">

                             <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="stock.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                 <i class="fas fa-seedling w3-xlarge"></i>
                                 <p class="w3-small" style="margin:0;">Stock</p>
                             </a>

                         </div>

                         <!-- Socios -->

                         <div class="w3-cell w3-center w3-mobile">

                             <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="socios.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                 <i class="fas fa-user-cog w3-xlarge"></i>
                                 <p class="w3-small" style="margin:0;">Socios</p>
                             </a>

                         </div>

                         <!-- Administración -->

                         <div class="w3-cell w3-center w3-mobile">

                             <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="../admin/gestionarSocios.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                 <i class="fas fa-chart-line w3-xlarge"></i>
                                 <p class="w3-small" style="margin:0;">Finanzas</p>
                             </a>

                         </div>
                     </div>
                 </div>

                 <div class="w3-rest">


                 </div>
             </div>
         </div>