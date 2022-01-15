<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CCSM</title>
    <link rel="icon" href="/club/img/ccms.ico" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="/club/css/w3.css">
    <link rel="stylesheet" href="/club/css/themes/w3-theme-<?php
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
                                                    ?>.css">
    <link rel="stylesheet" href="/club/webfonts/stylesheet.css">
    <link rel="stylesheet" href="/club/fontawesome5/css/all.css">
    <link rel="stylesheet" href="/club/css/style.css">
    <link rel="stylesheet" href="/club/css/carrito.css">
</head>
<style>

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: <?php
                        $sql = "SELECT *  FROM settings";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo $row['titulos'];
                        }
                        ?>;
    }
</style>

<body class="w3-theme-light font-<?php
                                    while ($row = $result->fetch_assoc()) {
                                        echo $row['fuente'];
                                    }
                                    $conn->close();
                                    ?>">
        <style>
            #login-panel {
                margin: 0 auto;
                width: 350px;
            }
            .flip-container {
                height: 420px;
                margin-top: 80px;
                perspective: 1000px;
                transform-style: preserve-3d;
            }
            .back,
            .front {
                backface-visibility: hidden;
                left: 0;
                padding: 40px;
                position: absolute;
                top: 0;
                transform-style: preserve-3d;
                transition: .6s;
                width: 100%;
            }
        </style>
        <div class="w3-container">
            
            <div class="w3-third">
                <div id="login-panel">
                    <div class="flip-container w3-margin-bottom" style="margin-top: 265px;">
                        <a href="admin/home/index.php">
                            <div class="front panel w3-white w3-border w3-border-theme w3-center">
                                <h4 id="shop_name" class="w3-center w3-text-theme">Adminitración</h4>
                                <i class="fas fa-cogs w3-jumbo w3-text-theme"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="w3-third">
                <div id="login-panel">
                    <div class="flip-container w3-margin-bottom" style="margin-top: 265px;">
                        <a href="recepcion/index.php">
                            <div class="front panel w3-white w3-border w3-border-theme w3-center">
                                <h4 id="shop_name" class="w3-center w3-text-theme">Recepción</h4>
                                <i class="fas fa-concierge-bell w3-jumbo w3-text-theme"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="w3-third">
                <div id="login-panel">
                    <div class="flip-container w3-margin-bottom" style="margin-top: 265px;">
                        <a href="dispensario/index.php">
                            <div class="front panel w3-white w3-border w3-border-theme w3-center">
                                <h4 id="shop_name" class="w3-center w3-text-theme">Dispensario</h4>
                                <i class="fas fa-store w3-jumbo w3-text-theme"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>