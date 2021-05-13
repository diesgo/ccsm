<?php
$titulo = "NUEVA VARIEDAD";
include '../templates/header.php';
?>



<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        if (isset($_POST['altaButton'])) {
            require_once '../../config/config.php';

            $nombre = $_POST['nombre'];

            // Create connection

            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

            // Check connection

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO variedades (nombre) VALUES ('$nombre')";

            if ($conn->query($sql) === TRUE) {
                echo "Se ha creado un nuevo registro";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
        ?>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="#" method="post" name="altaSocio" id="altaSocio">
                <!-- FICHA VARIEDAD  -->
                <div class="w3-content w3-padding">
                    <!-- FILA 1: NOMBRE -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for='nombre'>Variedad</label>
                            <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' placeholder='nombre'>
                            <small id="info_nombre"></small>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Guardar" name="altaButton" class="w3-button w3-theme w3-round">
                    <a href="index.php" class="w3-button w3-theme w3-round">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>