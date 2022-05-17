<?php
$titulo = "FUENTES";
include '../templates/header.php';
 ?>

             <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>


<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-toolbox"></i> <?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        if (isset($_POST['alta'])) {
            require_once '../../config/conexion.php';
            $fuente = $_POST['fuente'];
            $sql = "INSERT INTO fuentes (fuente) VALUES ('$fuente')";
            if ($conn->query($sql) === TRUE) {
                //  
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

<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="#" method="post" name="altaFuente" id="altaFuente">
                <!-- FICHA FUENTE -->
                <div class="w3-content w3-padding">
                    <!-- FILA 1: FUENTE -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for='fuente'>Tipografía</label>
                            <input class='w3-input w3-border w3-round' name='fuente' id='fuente' type='text'>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Guardar" name="alta" class="w3-button w3-theme w3-round">
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