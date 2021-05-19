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
        if (isset($_POST['actualizar'])) {
            $id = $productos['id'];
            $cantidad = $_POST['cantidad'];
            $dispensario = $_POST['dispensario'];
            $sql = "UPDATE productos SET cantidad='" . $cantidad . "', dispensario='" . $dispensario . "' WHERE id=" . $id . ";";
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
            $dispensario = $row['dispensario'];
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
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="chargeProduct" id="chargeProduct">
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
                        </div>
                        <div class="w3-col l3 m3">
                            <div class="w3-container"></div>
                        </div>
                    </div>
                    <!-- FILA 2 -->
                    <div class="w3-row-padding w3-margin-bottom">
                        <!-- ALMACEN -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-row">
                                    <h3 class="w3-text-theme w3-center">Reserva</h3>
                                    <div class="w3-col">

                                        <label class="w3-text-theme" for="cantidad">Stock actual:</label>
                                        <input type="text" name="cantidad" id="cantidad" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" value=<?php echo $productos['cantidad']; ?>>

                                        <label class="w3-text-theme" for="add">Cargar:</label>
                                        <input type="text" name="add" id="add" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" disabled>

                                        <input type="button" value="Recargar" class="w3-input w3-padding w3-margin-top w3-theme w3-border w3-border-theme w3-round w3-hover-white w3-hover-text-theme w3-margin-bottom">
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

                                        <label class="w3-text-theme" for="dispensario">Cantidad dispensario:</label>
                                        <input type="text" name="dispensario" id="dispensario" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" value=<?php echo $productos['dispensario']; ?>>

                                        <label class="w3-text-theme" for="addDisp">Cargar:</label>
                                        <input type="text" name="addDisp" id="addDisp" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" onkeyup="charge();" disabled>

                                        <input type="button" value="Recargar" class="w3-input w3-margin-top w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme w3-margin-bottom" onclick="charge();">

                                    </div>
                                </div>
                            </div>
                            <script>
                                function charge() {
                                    let b = chargeProduct.addDisp;
                                    let a = chargeProduct.dispensario;
                                    let cc = chargeProduct.cantidad;
                                    let c= parseInt(chargeProduct.cantidad.value);
                                    b.removeAttribute('disabled');;
                                    let d = parseInt(b.value);
                                    if (d>c) {
                                        alert("No tienes suficiente stock");
                                    }
                                    a.value = d;
                                    cc.value = c - d;
                                }
                            </script>
                        </div>
                        <!-- BOTE -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-row">
                                    <h3 class="w3-text-theme w3-center">bote</h3>
                                    <div class="w3-col">

                                        <label class="w3-text-theme" for="bote">Tara actual:</label>
                                        <input type="text" name="bote" id="bote" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" value=<?php echo $productos['bote']; ?> disabled>

                                        <label class="w3-text-theme" for="newBote">Nuevo bote:</label>
                                        <input type="text" name="newBote" id="newBote" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" disabled>

                                        <input type="button" value="Recargar" class="w3-input w3-margin-top w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme w3-margin-bottom">

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