<?php
$titulo = "EDITAR VARIEDADES";
include '../templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        // require '../../config/functions.php';
        $variedades = getVariedadesById($_GET['id']);
        require "../../config/conexion.php";
        if (isset($_POST['actualizar'])) {
            $id = $variedades['id'];
            $nombre = $_POST['nombre'];
            $sql = "UPDATE variedades SET nombre ='" . $nombre . "' WHERE id=" . $id . ";";
            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id'])) {
                $sql = "SELECT min(id) FROM variedades";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id)'];
            } else {
                $id = $_POST["id"];
            }
            $sql = "SELECT * FROM variedades WHERE id='$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $nombre = $row['nombre'];
        }
        $sql = "SELECT * FROM variedades";
        $result = mysqli_query($conex, $sql);

        ?>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">
                <!-- FICHA SOCIO  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 2: ROL Y DESCRIPCIÓN -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="nombre" class="w3-text-theme">Nombre</label><br>
                            <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value=<?php echo $variedades['nombre']; ?>>
                            <small id="info_nombre"></small>
                        </div>
                        <!-- DESCRIPCIÓN -->
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-theme w3-round">
                    <a href="index.php" class="w3-button w3-theme w3-round">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/fecha.js"></script>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>