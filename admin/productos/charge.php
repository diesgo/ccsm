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
            $id = $productos['id_producto'];
            $stock = $productos['cantidad'];
            $origen = $_POST['id_proveedor'];
            $recarga = $_POST['recarga'];
            $pc = $_POST['pc'];
            $stock_total = $stock + $recarga;
            $sql = "UPDATE productos SET cantidad ='" . $stock_total . "', pc = '" . $pc ."' WHERE id_producto = " . $id . ";";
            echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
            mysqli_query($conex, $sql);
            $sql = "INSERT INTO recargas (proveedor_id, producto_id, stock_antes, recarga, stock_despues, pc)
             VALUES ('$origen', '$id', '$stock', '$recarga', '$stock_total', '$pc')";
             $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
             if ($conn->query($sql) === TRUE) {
                 echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $conn->close() or die("Error al ejecutar la consulta");
            } else {
            if (!isset($_POST['id'])) {
                $sql = "SELECT min(id_producto) FROM productos";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id_producto)'];
            } else {
                $id = $_POST["id"];
            }
            $sql = "SELECT * FROM productos WHERE id_producto = '$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id_producto'];
            $dispensario = $row['dispensario'];
        }

        ?>
    </div>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding w3-responsive" style="min-height: 616px;">
    <div class="w3-content">
        <div class="w3-row-padding w3-margin-bottom">
            <h1 style="text-transform: uppercase;" class="w3-text-theme w3-center"><?php echo $productos['nombre_producto'] ?> # <?php echo $productos['id_producto'] ?></h1>
            <h3 class="w3-text-theme w3-center">Tipo de servicio: <span style="text-transform: capitalize;"><?php echo $productos['nombre_servicio'] ?></span></h3>
        </div>
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-col l3 m3 w3-padding w3-margin-top w3-margin-bottom">
                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                    
                </div>
            </div>
            <div class="w3-col l3 m3 w3-padding w3-margin-top w3-margin-bottom">
                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                    <label for="cantidadAhora" class="w3-text-theme">Stock Actual</label>
                    <input id="cantidadAhora" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" name="pc" value="<?php echo $productos['cantidad']; ?>" disabled>
                </div>
            </div>
            <div class="w3-col l3 m3 w3-padding w3-margin-top w3-margin-bottom">
                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                    <label for="cantidadAhora" class="w3-text-theme">Cantidad en dispensario</label>
                    <input id="cantidadAhora" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" name="pc" value="<?php echo $productos['dispensario']; ?>" disabled>
                </div>
            </div>
            <div class="w3-col l3 m3 w3-padding w3-margin-top w3-margin-bottom">
                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                    
                </div>
            </div>
        </div>
    </div>
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="chargeProduct" id="chargeProduct">
                <div class="w3-content w3-padding">
                    
                    <!-- FILA 1 -->
                    
                    <div class="w3-row-padding w3-margin-bottom">
                        <!-- ORIGEN -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-container">
                                    <label for="id_proveedor">Origen</label>
                                    <select name="id_proveedor" class="w3-select w3-white w3-border w3-border-theme w3-round w3-margin-bottom">
                                        <?php
                                        $proveedores = getProveedores();
                                        foreach ($proveedores as $proveedor) :
                                        ?>
                                        <option value=<?php echo $proveedor['id_proveedor']; ?>><?php echo $proveedor['nombre_proveedor'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- RECARGA -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-container">
                                    <label for="recarga" class="w3-text-theme">Recarga</label>
                                    <input id="recarga" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" name="recarga" value="" required>
                                </div>
                            </div>
                        </div>
                        <!-- PRECIO COMPRA -->
                        <div class="w3-col l4 m4 w3-padding">
                            <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                <div class="w3-container">
                                    <label class="w3-text-theme" for="pc">Precio de compra</label>
                                    <input type="text" name="pc" id="pc" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" value="" required>
                                </div>
                            </div>
                        </div>
                        <script>
                        let a = document.getElementById('addDisp');
                        </script>
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