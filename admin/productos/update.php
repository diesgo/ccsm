<?php
$titulo = "EDITAR PRODUCTO";
include '../templates/header.php';
$productos = getProductosById($_GET['id']);
?>

<!-- HEADER -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?> id: <?php echo $productos['id'] ?></b></h2>
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
            echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Cambios guardados</h3>";
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
                    <div class="w3-content">
                        <div class="w3-row-padding">

                            <!-- NOMBRE Y TIPO DE VENTA -->

                            <div class="w3-col">
                                <h2 style="text-transform: uppercase;" class="w3-center w3-text-theme"><?php echo $productos['nombre'] ?></h2>
                                <h4 class="w3-center w3-text-theme">Tipo de servicio: <span style="text-transform: capitalize;"><?php echo $productos['disp'] ?></span></h4>
                            </div>

                        </div>

                        <div class="w3-rpww-padding">

                            <!-- PVC -->

                            <div class="w3-col l3 m3 w3-padding">
                                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                    <label for="pvc" class="w3-text-theme">Precio actual de compra</label>
                                    <input id="pvc" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" disabled type="text" name="pvc" value=<?php echo $productos['pvc'] ?>>
                                    <input class="w3-input w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme" type="button" name="changePvc" value="Cambiar" onclick="update('pvc');">
                                </div>
                            </div>

                            <!-- PVP -->

                            <div class="w3-col l3 m3 w3-padding">
                                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                    <label for="pvp" class="w3-text-theme">Precio actual de venta</label>
                                    <input id="pvp" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" disabled type="text" name="pvp" value=<?php echo $productos['pvp'] ?> disabled>
                                    <input class="w3-input w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme" type="button" name="changePvp" value="Cambiar" onclick="update('pvp');">
                                </div>
                            </div>

                            <!-- STOCK ACTUAL -->

                            <div class="w3-col l3 m3 w3-padding">
                                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                    <label for="cantidad" class="w3-text-theme">Stock actual</label>
                                    <input id="cantidad" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" disabled type="text" name="cantidad" value=<?php echo $productos['cantidad'] ?>>
                                    <a href="charge.php?id=<?php echo $productos['id'] ?>" class="w3-button w3-bar w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme">Recargar</a>
                                </div>
                            </div>

                            <!-- BOTE -->

                            <div class="w3-col l3 m3 w3-padding">
                                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                    <label for="bote" class="w3-text-theme">Bote dispensario (tara)</label>
                                    <input id="bote" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" disabled type="text" name="bote" value=<?php echo $productos['bote'] ?>>
                                    <input class="w3-input w3-theme w3-border w3-border-theme w3-round w3-margin-bottom w3-hover-white w3-hover-text-theme" type="button" name="changeBote" value="Cambiar" onclick="update('bote');">
                                </div>
                            </div>

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
<script>
    function update(id) {
        var btn = document.getElementById(id);
        btn.removeAttribute('disabled');
    }
</script>

<!-- !END PAGE CONTENT! -->

<?php
include '../templates/footer.php';
?>