<?php
$titulo = "RECARGAR";
include '../templates/header.php';
require '../../config/functions.php';
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
        if (isset($_POST['actualizar'])) {
            $id = $productos['id'];
            $cantidad = $_POST['cantidad'];
            $sql = "UPDATE productos SET cantidad='" . $cantidad . "' WHERE id=" . $id . ";";
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
            $cantidad = $row['cantidad'];
        }
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conex, $sql);
        ?>
    </div>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="altaSocio" id="altaSocio">
                <div class="w3-content w3-padding">
                    <!-- FILA 1 -->
                    <div class="w3-row-padding w3-margin-bottom">
                        <div class="w3-col l3 m3">
                            <div class="w3-container"></div>
                        </div>
                        <div class="w3-col l6 m6 w3-padding w3-border w3-border-theme w3-round">
                            <!--  NOMBRE Y TIPO DE VENTA -->
                            <div class="w3-container">
                                <h1 style="text-transform: uppercase;" class="w3-text-theme w3-center"><?php echo $productos['nombre'] ?> # <?php echo $productos['id'] ?></h1>
                                <h3 class="w3-text-theme w3-center">Tipo de servicio: <span style="text-transform: capitalize;"><?php echo $productos['disp'] ?></span></h3>
                            </div>
                            <!-- PESO BOTE -->
                            <div class="w3-container w3-margin-bottom">
                                <label for="bote" class="w3-text-theme">Peso del bote:</label>
                                <input class="w3-input w3-border w3-border-theme w3-round" name="bote" id="bote" type="text" value=<?php echo $productos['bote']; ?>>
                            </div>
                        </div>
                        <div class="w3-col l3 m3">
                            <div class="w3-container"></div>
                        </div>
                    </div>
                    <!-- FILA 2 -->
                    <div class="w3-row-padding w3-margin-bottom">
                        <div class="w3-col l6 m6 w3-padding">
                            <!-- STOCK -->
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <h3 class="w3-text-theme w3-center">Almacén</h3>
                                <div class="w3-row">
                                    <div class="w3-col l6 m6 w3-padding">
                                        <legend class="w3-text-theme">Stock actual:</legend>
                                        <p class="w3-input w3-border w3-border-theme w3-round w3-margin-0"><?php echo $productos['cantidad']; ?></p>
                                    </div>
                                    <div class="w3-col l6 m6 w3-padding">
                                        <label for="">Peso a añador</label>
                                        <input type="text" name="" id="" class="w3-input w3-border w3-border-theme w3-round">
                                    </div>
                                </div>
                                <div class="w3-row">
                                    <div class="w3-col l12 m12 w3-padding">
                                        <input type="button" value="Recargar" class="w3-bar w3-padding w3-margin-top w3-theme w3-border w3-border-theme w3-round w3-hover-white w3-hover-text-theme">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w3-col l6 m6 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <h3 class="w3-text-theme w3-center">Dispensario</h3>
                                <div class="w3-row">
                                    <div class="w3-col l6 m6 w3-padding">
                                        <legend class="w3-text-theme">Dispenario:</legend>
                                        <p class="w3-input w3-border w3-border-theme w3-round w3-margin-0"><?php echo $productos['cantidad']; ?></p>
                                    </div>
                                    <div class="w3-col l6 m6 w3-padding">
                                        <label for="">Peso a añadir</label>
                                        <input type="text" name="" id="" class="w3-input w3-border w3-border-theme w3-round">
                                    </div>
                                </div>
                                <div class="w3-row">
                                    <div class="w3-col l12 m12 w3-padding">
                                        <input type="button" value="Recargar" class="w3-bar w3-padding w3-margin-top w3-theme w3-border w3-border-theme w3-round w3-hover-white w3-hover-text-theme">
                                    </div>
                                </div>
                            </div>
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