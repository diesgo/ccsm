<?php
$titulo = "RECARGAR";
include '../templates/header.php';
$productos = getProductosById($_GET['id']);
?>

<!-- HEADER -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        require '../../config/conexion.php';
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conex, $sql);
        if (isset($_POST['actualizar'])) {
            $id = $productos['id'];
            $dispensario = $productos['dispensario'] + $_POST['addDisp'];
            $cantidad = $productos['cantidad'] - $_POST['addDisp'];
            $sql = "UPDATE productos SET dispensario ='" . $dispensario . "', cantidad ='" . $cantidad . "' WHERE id=" . $id . ";";
            echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id'])) {
                $sql = "SELECT min(id) FROM productos";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id)'];
            } else {
                $id = $_POST["id"];
            }
            $sql = "SELECT * FROM productos WHERE id='$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            $dispensario = $row['dispensario'];
        }

        ?>
    </div>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="chargeProduct" id="chargeProduct">
                <div class="w3-content w3-padding">
                    <!-- FILA 1 -->
                    <div class="w3-row-padding w3-margin-bottom">

                        <!--  NOMBRE Y TIPO DE VENTA -->

                        <h1 style="text-transform: uppercase;" class="w3-text-theme w3-center"><?php echo $productos['nombre'] ?> # <?php echo $productos['id'] ?></h1>
                        <h3 class="w3-text-theme w3-center">Tipo de servicio: <span style="text-transform: capitalize;"><?php echo $productos['servicio'] ?></span></h3>
                    </div>
                    <!-- FILA 2 -->
                    <div class="w3-row-padding w3-margin-bottom">
                        <!-- ALMACEN -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-row">
                                    <h3 class="w3-text-theme w3-center">Stock</h3>
                                    <div class="w3-col">

                                        <legend class="w3-text-theme" for="cantidad">Stock actual:</legend>
                                        <p id="cantidad" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom"><?php echo $productos['cantidad']; ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DISPENSARIO -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-row">
                                    <h3 class="w3-text-theme w3-center">Dispensario</h3>
                                    <div class="w3-col">

                                        <legend class="w3-text-theme">Cantidad dispensario:</legend>
                                        <p id="dispensario" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom"><?php echo $productos['dispensario']; ?></p>
                                        <label for="addDisp" class="w3-text-theme">Recargar</label>
                                        <input type="text" name="addDisp" id="addDisp" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" value="0">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BOTE -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-row">
                                    <h3 class="w3-text-theme w3-center">Bote</h3>
                                    <div class="w3-col">

                                        <legend class="w3-text-theme">Tara actual:</legend>
                                        <p id="bote" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom"><?php echo $productos['bote']; ?></p>
                                        <label class="w3-text-theme" for="newBote">Nuevo bote:</label>
                                        <input type="text" name="newBote" id="newBote" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" value="0">

                                    </div>
                                </div>
                            </div>
                            <script>
                                let a = document.getElementById('addDisp');
                            </script>
                        </div>
                    </div>
                    <!-- FILA 3 -->
                    <div class="w3-row-padding w3-center w3-margin-bottom">
                        <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">
                        <a href="index.php" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">Volver</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- !END PAGE CONTENT! -->

<?php
include '../templates/footer.php';
?>