<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fontawesome5/css/all.min.css">
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title> <?php echo $titulo; ?></title>
</head>

<body class="w3-light-grey">
    <div id="pantalla" class="w3-container">

        <!-- CABECERA -->

        <div class="w3-margin-top">
            <div class="w3-container w3-center">
                <div class="w3-quarter">
                    <img src="../../img/ccms_logo.png" alt="C C M S" class="w3-image" width="110">
                </div>
                <div class="w3-half w3-padding-24">
                    <h1 class="w3-text-green w3-white w3-border w3-border-green w3-round"> <?php echo $titulo; ?></h1>
                </div>
            </div>
        </div>

        <!-- MENÚ -->

        <div class="w3-cell-row" style="margin:0 auto; padding: 0 23%;">

            <!-- DISPENSARIO -->

            <div class="w3-cell w3-center w3-mobile">

                <a  class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" 
                        href="../../index.php"
                        style="text-decoration:none; width: 110px; padding: 10px;">
                    <i class="fas fa-store w3-xxlarge"></i>
                    <p class="w3-small" style="margin:0;">Dispensario</p>
                </a>

            </div>

            <!-- ADMINISTRACIÓN -->

            <div class="w3-cell w3-center w3-mobile">

                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button"
                    href="../index.php"
                    style="text-decoration:none; width: 110px; padding: 10px;">
                    <i class="fas fa-cogs w3-xxlarge"></i>
                    <p class="w3-small" style="margin:0;">Administración</p>
                </a>

            </div>

            <div class="w3-cell w3-center w3-mobile">

                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button"
                    href="../productos/gestionarProductos.php"
                    style="text-decoration:none; width: 110px; padding: 10px;">
                    <i class="fas fa-seedling w3-xxlarge"></i>
                    <p class="w3-small" style="margin:0;">Stock</p>
                </a>

            </div>

            <!-- Socios -->

            <div class="w3-cell w3-center w3-mobile">

                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button"
                    href="../socios/gestionarSocios.php"
                    style="text-decoration:none; width: 110px; padding: 10px;">
                    <i class="fas fa-user-cog w3-xxlarge"></i>
                    <p class="w3-small" style="margin:0;">Socios</p>
                </a>

            </div>

            <!-- Administración -->

            <div class="w3-cell w3-center w3-mobile">

                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button"
                    href="../admin/gestionarSocios.php"
                    style="text-decoration:none; width: 110px; padding: 10px;">
                    <i class="fas fa-chart-line w3-xxlarge"></i>
                    <p class="w3-small" style="margin:0;">Finanzas</p>
                </a>

            </div>
        </div>