<?php
$titulo = "DISPENSARIO";
include "../templates/header.php"
?>
    <div id="pantalla" class="w3-container">

        <!-- CABECERA -->

        <div class="w3-margin-top">
            <div class="w3-container w3-center">
                <div class="w3-quarter">
                    <img src="img/ccms_logo.png" alt="C C M S" class="w3-image" width="150">
                </div>
                <div class="w3-half w3-padding-48">
                    <h1 class="w3-text-green w3-white w3-border w3-border-green w3-round">Cannabis Club System Management</h1>
                </div>
            </div>
        </div>

        <!-- Captar chip -->

        <div class="w3-display-container" style="min-height: 100px;">
            <div class="w3-display-middle w3-center">
                <p>ID Socio</p>
                <input class="w3-border-green w3-input" type="text" id="id_socio" autofocus>
            </div>
        </div>

        <!-- MENÚ -->

        <div class="w3-cell-row" style="margin: 2% auto; padding: 0 23%;">

            <!-- FLORES Y DERIVADOS -->

            <div class="w3-cell w3-padding">
                <div class="w3-container w3-padding w3-center">
                    <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="#" style="text-decoration:none; width: 150px; padding: 32px 16px;">
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

        <!-- FOOTER -->

        <footer class="w3-margin-top w3-row-padding">

            <!-- Sección 1 footer -->

            <div class="w3-col l3 m3">
                <div class="w3-container w3-center">
                    <p>Powered by</p>
                    <img src="img/logo_w3css.png" alt="W3 css" class="w3-image" width="60px">
                </div>
            </div>

            <!-- Sección 2 footer -->

            <div class="w3-col l3 m3">
                <div class="w3-container w3-center">
                    <p>Powered by</p>
                    <img src="img/logo_fontawesome.png" alt="W3 css" class="w3-image" width="60px">
                </div>
            </div>

            <!-- Sección 3 footer -->

            <div class="w3-col l3 m3">
                <div class="w3-container w3-center">
                    <p>Designed by</p>
                    <img src="img/logo_ddbold.png" alt="W3 css" class="w3-image" width="60px">
                </div>
            </div>

            <!-- Sección 4 footer -->

            <div class="w3-col l3 m3">
                <div class="w3-container w3-center">
                    <p>Sección footer</p>
                </div>
            </div>
        </footer>
    </div>
    <?php
    include "../templates/footer.php";
    ?>