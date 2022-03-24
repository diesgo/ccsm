<!DOCTYPE html>
    <html lang="es">
        <head>
            <?php
            require "../../config.php";
            require '../../config/functions.php';
            $settings = getSetingsById(1);
            ?>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo $titulo ?> | CCSM</title>
            <link rel="icon" href="../../img/ccms.ico" type="image/gif" sizes="16x16">
            <link rel="stylesheet" href="../../webfonts/stylesheet.css">
            <link rel="stylesheet" href="../../fontawesome5/css/all.css">
            <link rel="stylesheet" href="../../css/w3.css">
            <link rel="stylesheet" href="../../css/themes/w3-theme-<?php echo $settings['color']; ?>.css">
            <link rel="stylesheet" href="../../css/style.css">
        </head>
        <style>
        .panel {
            box-shadow: 0 1px 2px rgba(0, 0, 0, .3);
        }
        label, legend,
        th, button,
        input[type="submit"], input[type="button"],
        a, h1, h2, h3, h4, h5, h6 {
            font-family: <?php echo $settings['titulos'] ?>;
        }
        </style>
        <body class="w3-theme-light font-<?php echo $settings['fuente'] ?>">
            <!-- Top container -->
            <div class="w3-container w3-top w3-theme-dark w3-large" style="z-index:4; padding: 8px 8px">
                <div class="w3-bar w3-padding">
                    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-theme" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
                    <a href="../home/index.php">
                        <span class="w3-bar-item w3-white" style="padding: 8px; border-radius: 50%;"><img class="w3-image" src="../../img/ccms_logo.png" alt="logo" style="max-width:30px"></span>
                        <span class="w3-bar-item w3-center">Cannabis Club System Management</span>
                    </a>
                    <a class="w3-bar-item w3-button w3-border w3-border-theme w3-round w3-theme-d3 w3-hover-white w3-hover-text-theme w3-right" href="../../admin/home/index.php">Administración</a>
                </div>
            </div>

            <!-- Sidebar/menu -->

            <nav class="w3-sidebar w3-collapse w3-theme" style="z-index:3; top:58px; width:250px;" id="mySidebar"><br>

            </nav>

            <!-- Overlay effect when opening sidebar on small screens -->

            <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

            <div class="w3-main" style="margin-left:250px; margin-top:78px;">
                <div class="w3-container w3-padding w3-responsive" style="min-height: 719px;">