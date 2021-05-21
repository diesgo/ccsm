<?php
$titulo = "Esquemas de color";
include '../templates/header.php';
?>

<?php
if (isset($_POST['altaButton'])) {
    require_once '../../config/config.php';

    $color = $_POST['color'];

    // Create connection

    $conn =
        new mysqli(
            DBHOST,
            DBUSER,
            DBPWD,
            DBNAME
        );

    // Check connection

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO color_tema (color)
    VALUES ('$color')";

    if ($conn->query($sql) === TRUE) {
        //  
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>



<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-paint-roller"></i> <?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <!-- <a class="w3-right w3-button w3-theme-dark w3-border w3-border-theme-dark w3-round w3-hover-white w3-hover-theme-dark w3-hover-text-theme-dark" href="color.php">+ Añadir esquema de color</a> -->
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="#" method="post" name="altaSocio" id="altaSocio">
                <!-- FICHA COLOR -->
                <div class="w3-content w3-padding">
                    <!-- FILA 1: ROL -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for='color'>Color</label>
                            <input class='w3-input w3-border w3-round' name='color' id='color' type='text'>
                            <small id="info_color"></small>
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