<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $titulo ?> | CCSM</title>
    <link rel="icon" href="/club/img/ccms.ico" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="/club/css/w3.css">
    <link rel="stylesheet" href="/club/css/w3-theme-<?php
                                                    require '../config/conexion.php';
                                                    $sql = "SELECT * FROM settings";
                                                    $result = $conn->query($sql);
                                                    $row = $result->fetch_assoc();
                                                    echo $row['color'];
                                                    ?>.css">
    <link rel="stylesheet" href="/club/webfonts/stylesheet.css">
    <link rel="stylesheet" href="/club/fontawesome5/css/all.css">
    <link rel="stylesheet" href="/club/css/style.css">
    <link rel="stylesheet" href="/club/css/carrito.css">
</head>
<style>
    .panel {
        box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: <?php echo $row['titulos'];?>;
    }
</style>

<body class="w3-theme-light font-<?php echo $row['fuente']; $conn->close();?>">
    <div id="pantalla" class="w3-container">

        <!-- CABECERA -->

        <div class="w3-margin-top">
            <div class="w3-container w3-center">
                <div class="w3-quarter">
                    <a href="index.php"><img src="../img/ccms_logo.png" alt="C C M S" class="w3-image" width="110"></a>

                </div>
                <div class="w3-half w3-padding">
                    <h1 class="w3-text-theme w3-white w3-border w3-border-theme w3-round">Cannabis Club System Management</h1>
                </div>
            </div>

            <!-- MENÚ -->

            <div class="w3-container">
                <div class="w3-cell-row" style="margin:0 auto; padding: 0 23%;">

                    <!-- DISPENSARIO -->

                    <div class="w3-cell w3-center w3-mobile">

                        <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="menu.php" style="text-decoration:none; width: 110px; padding: 10px;">
                            <i class="fas fa-store w3-xxlarge"></i>
                            <p class="w3-small" style="margin:0;">Menu</p>
                        </a>

                    </div>

                    <!-- ADMINISTRACIÓN -->

                    <div class="w3-cell w3-center w3-mobile">

                        <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="../admin/home/index.php" style="text-decoration:none; width: 110px; padding: 10px;">
                            <i class="fas fa-cogs w3-xxlarge"></i>
                            <p class="w3-small" style="margin:0;">Administración</p>
                        </a>

                    </div>

                    <div class="w3-cell w3-center w3-mobile">

                        <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="stock.php" style="text-decoration:none; width: 110px; padding: 10px;">
                            <i class="fas fa-seedling w3-xxlarge"></i>
                            <p class="w3-small" style="margin:0;">Stock</p>
                        </a>

                    </div>

                    <!-- Socios -->

                    <div class="w3-cell w3-center w3-mobile">

                        <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="socios.php" style="text-decoration:none; width: 110px; padding: 10px;">
                            <i class="fas fa-user-cog w3-xxlarge"></i>
                            <p class="w3-small" style="margin:0;">Socios</p>
                        </a>

                    </div>

                    <!-- Administración -->

                    <div class="w3-cell w3-center w3-mobile">

                        <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="../admin/gestionarSocios.php" style="text-decoration:none; width: 110px; padding: 10px;">
                            <i class="fas fa-chart-line w3-xxlarge"></i>
                            <p class="w3-small" style="margin:0;">Finanzas</p>
                        </a>

                    </div>
                </div>

            </div>
        </div>