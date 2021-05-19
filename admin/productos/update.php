<?php
$titulo = "EDITAR PRODUCTO";
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
            $bote = $productos['bote'];
            $pvc = $productos['pvc'];
            $pvp = $_POST['pvp'];
            $sql = "UPDATE productos SET bote ='" . $bote . "', pvc ='" . $pvc . "', pvp='" . $pvp . "' WHERE id=" . $id . ";";
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
            $sql = "SELECT id, bote, pvc, pvp FROM productos WHERE id='$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            $bote = $row['bote'];
            $pvc = $row['pvc'];
            $pvp = $row['pvp'];
        }
        $sql = "SELECT id, bote, pvc, pvp FROM productos";
        $result = mysqli_query($conex, $sql);
        ?>
    </div>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="updateProducts" id="updateProducts">
                <!-- FICHA PRODUCTO  -->
                <div class="w3-container">

                    <!-- SECCIÓN NULA -->

                    <div class="w3-quarter">
                        <div class="w3-container">

                        </div>
                    </div>

                    <!--SECCIÓN CENTRAL -->

                    <div class="w3-half">
                        <div class="w3-row-padding">
                            <div class="w3-col l2 m2">
                                <div class="w3-container"></div>
                            </div>
                            <!-- NOMBRE Y TIPO DE VENTA -->
                            <div class="w3-col l5 m5">
                                <h2 style="text-transform: uppercase;" class="w3-center w3-text-theme"><?php echo $productos['nombre'] ?> # <?php echo $productos['id'] ?></h2>
                                <h4 class="w3-center w3-text-theme">Tipo de servicio: <span style="text-transform: capitalize;"><?php echo $productos['disp'] ?></span></h4>
                            </div>
                            <!-- PESO BOTE -->
                            <div class="w3-col l3 m3 w3-margin-top">
                                <div iclass="w3-col m2 l2 w3-padding w3-hide">
                                    <label for="bote" class="w3-text-theme">Peso del bote</label>
                                    <input id="bote" type="text" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" name="bote" value=<?php echo $productos['bote'] ?> disabled>
                                </div>
                            </div>
                        </div>
                        <div class="w3-container">
                            <!-- PVC -->
                            <div class="w3-third w3-padding">
                                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                    <label for="pvc" class="w3-text-theme">Precio actual de compra</label>
                                    <input id="pvc" type="text" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" name="pvc" value=<?php echo $productos['pvc'] ?> disabled>
                                    <input type="button" class="w3-input w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme" name="changePvc" value="Cambiar" onclick="update('pvc');">
                                </div>
                            </div>
                            <!-- PVP -->
                            <div class="w3-third w3-padding">
                                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                    <label for="pvp" class="w3-text-theme">Precio actual de venta</label>
                                    <input id="pvp" type="text" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" name="pvp" value=<?php echo $productos['pvp'] ?> disabled>
                                    <input type="button" class="w3-input w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme" name="changePvp" value="Cambiar" onclick="update('pvp');">
                                </div>
                            </div>
                            <!-- CANTIDAD -->
                            <div class="w3-third w3-padding">
                                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                    <label for="cantidad" class="w3-text-theme">Stock actual</label>
                                    <input type="text" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" name="cantidad" value=<?php echo $productos['cantidad'] ?> disabled>
                                    <a href="charge.php?id=<?php echo $productos['id'] ?>" class="w3-button w3-bar w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme">Recargar</a>
                                </div>
                            </div>
                            <script>
                                function update(id) {
                                    let x = document.getElementById(id);
                                    x.removeAttribute('disabled');
                                }
                            </script>
                        </div>
                    </div>

                    <!-- SECCIÓN NULA -->

                    <div class="w3-quarter">
                        <div class="w3-container">

                        </div>
                    </div>
                </div>
                <div class="w3-container w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">
                    <a href="index.php" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- !END PAGE CONTENT! -->

<?php
include '../templates/footer.php';
?>