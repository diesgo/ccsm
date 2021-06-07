<?php
$titulo = "EDITAR CATEGORIA";
include '../templates/header.php';
require '../config/functions.php';
$socios = getSocios();
?>
<div id="pantalla" class="w3-container">


    <!-- Captar chip -->

    <div class="w3-display-container" style="min-height: 100px;">
        <form accept-charset="utf-8" action="#" method="post" name="socioActivo" id="socioActivo">

            <div class="w3-display-middle w3-center">
                <p>ID Socio</p>
                <input class="w3-border-theme w3-input" type="text" name="id" id="id" autofocus>
            </div>
        </form>
    </div>


    <!-- MENÚ -->

    <div class="w3-cell-row" style="margin: 2% auto; padding: 0 23%;">

        <!-- FLORES Y DERIVADOS -->

        <div class="w3-cell w3-padding">
            <div class="w3-container w3-padding w3-center">
                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="dispensar.php" style="text-decoration:none; width: 150px; padding: 32px 16px;">
                    <i class="fas fa-cannabis w3-jumbo"></i>
                    <p>weed</p>
                </a>

            </div>
        </div>

        <!-- BAR -->

        <div class="w3-cell w3-padding">
            <div class="w3-container w3-padding w3-center">
                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="#" style="text-decoration:none; width: 150px; padding: 32px 16px;">
                    <i class="fas fa-coffee w3-jumbo"></i>
                    <p>BAR</p>
                </a>
            </div>
        </div>

        <!-- Socios -->

        <div class="w3-cell w3-padding">
            <div class="w3-container w3-padding w3-center">
                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="admin/socios/gestionarSocios.php" style="text-decoration:none; width: 150px; padding: 32px 16px;">
                    <i class="fas fa-user-cog w3-jumbo"></i>
                    <p>Socios</p>
                </a>
            </div>
        </div>

        <!-- Administración -->

        <div class="w3-cell w3-padding">
            <div class="w3-container w3-padding w3-center">
                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="admin/index.php" style="text-decoration:none; width: 150px; padding: 32px 16px;">
                    <i class="fas fa-cogs w3-jumbo"></i>
                    <p>Administración</p>
                </a>
            </div>
        </div>
    </div>
</div>
<?php
include "../templates/footer.php";
?>