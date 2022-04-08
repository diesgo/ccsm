<!DOCTYPE html>
    <html lang="es">
        <head>
            <?php
            require "../../config.php";
            require '../config/functions.php';
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
        label, legend,
        th, button,
        input[type="submit"], input[type="button"],
        a, h1, h2, h3, h4, h5, h6 {
            font-family: <?php echo $settings['titulos'] ?>;
        }
        </style>
        <body class="w3-theme-light font-<?php echo $settings['fuente'] ?>">
            <script src="../js/scripts_header.js"></script>

            <!-- Sidebar/menu -->

            

            <!-- Overlay effect when opening sidebar on small screens -->

        <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>