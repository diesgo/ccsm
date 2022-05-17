<?php
session_start();
echo $_SESSION['username'];
require "config.php";
require "config/functions.php";

// Create connection
$conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$setting = getSetingsById(1 );
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CCSM</title>
    <link rel="icon" href="img/ccms.ico" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/themes/w3-theme-<?php echo $setting['color'];?>.css">
    <link rel="stylesheet" href="webfonts/stylesheet.css">
    <link rel="stylesheet" href="fontawesome5/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/carrito.css">
</head>
<style>
    h1, h2, h3, h4, h5, h6 {
        font-family: <?php echo $setting['titulos'];?>;
    }
</style>

<body class="w3-theme-light font-<?php echo $setting['fuente']; ?>">
        <div class="w3-container w3-margin-top w3-margin-bottom">
            <div class="w3-cell-row w3-padding w3-theme w3-round w3-center w3-margin-bottom">
                <h1 class="font-sweet-leaf">C C S M</h1>
                <small>Cannabis Club System Management</small>
            </div>
            <div class="w3-content center">
            
                <div class="w3-row w3-padding-large">
                <div class="w3-col l4 m4 s12 w3-padding">
                        <a class="w3-btn w3-white w3-border w3-border-theme w3-round w3-block w3-margin-top w3-margin-bottom" href="admin/home/index.php">
                            <h4 class="w3-center w3-text-theme w3-small">Administración</h4>
                            <i class="fas fa-cogs w3-center w3-xxxlarge w3-margin-bottom chamaleon"></i>
                        </a>
                </div>
                <div class="w3-col l4 m4 s12 w3-padding">
                        <a class="w3-btn w3-white w3-border w3-border-theme w3-round w3-block w3-margin-top w3-margin-bottom" href="recepcion/index.php">
                            <h4 class="w3-center w3-text-theme w3-small">Recepción</h4>
                            <i class="fas fa-concierge-bell w3-center w3-xxxlarge w3-margin-bottom chamaleon"></i>
                        </a>
                </div>
                <div class="w3-col l4 m4 s12 w3-padding">
                        <a class="w3-btn w3-white w3-border w3-border-theme w3-round w3-block w3-margin-top w3-margin-bottom" href="dispensario/home/index.php">
                            <h4 class="w3-center w3-text-theme w3-small">Dispensario</h4>
                            <i class="fas fa-store w3-center w3-xxxlarge w3-margin-bottom chamaleon"></i>
                        </a>
                </div>
            
            </div>
        </div>
        </div>
</body>

</html>