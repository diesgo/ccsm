                <?php
                    $titulo = "RECARGAR";
                    include '../templates/headerClean.php';
                    $productos = getProductsById($_GET['id']);
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

                <!-- !PAGE CONTENT! -->

                <div class="w3-content">
                    <div class="w3-row w3-margin-bottom">
                        <h1 style="text-transform: uppercase;" class="w3-text-theme w3-center"><?php echo $productos['nombre_producto'] ?> # <?php echo $productos['id_producto'] ?></h1>
                        <h3 class="w3-text-theme w3-center">Tipo de servicio: <?php echo $productos['nombre_servicio'] ?></span></h3>
                    </div>
                </div>

                <!-- FORMULARIO DE RECARGA -->

                <div class="w3-content">
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="chargeProduct" id="chargeProduct" class="w3-theme-l4 w3-round w3-padding">
                        <div class="w3-content w3-padding">
                            <div class="w3-row w3-margin-bottom">

                                <!-- INFORMACIÓN ESTACO STOCK -->

                                <div class="w3-col l3 m3 s12 w3-padding w3-margin-top w3-margin-bottom">
                                    <p class="w3-text-theme">Stock Actual: <span class="w3-text-grey"><b><?php echo $productos['cantidad']; ?></b> gr.</span></p>
                                    <p class="w3-text-theme">En dispensario: <span class="w3-text-grey"><b><?php echo $productos['dispensario']; ?></b> gr.</span></p>
                                </div>

                                <!-- ORIGEN DE LA RECARGA -->

                                <div class="w3-col l3 m3 s12 w3-padding w3-margin-top w3-margin-bottom">
                                    <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
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

                                <!-- CANRIDAD RECARGADA -->

                                <div class="w3-col l3 m3 s12 w3-padding w3-margin-top w3-margin-bottom">
                                    <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                                        <label for="recarga" class="w3-text-theme">Recarga</label>
                                        <input id="recarga" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" placeholder="gr." name="recarga" value="" required>
                                    </div>
                                </div>

                                <!-- PRECIO COMPRA -->

                                <div class="w3-col l3 m3 s12 w3-padding w3-margin-top w3-margin-bottom">
                                    <div class="w3-container w3-padding w3-border w3-border-theme w3-round w3-margin-bottom">
                                        <div class="w3-container">
                                            <label class="w3-text-theme" for="pc">Precio de compra</label>
                                            <input type="text" name="pc" id="pc" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" placeholder="€" value="" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <script>
                                let a = document.getElementById('addDisp');
                            </script>

                            <!-- BOTONES DE NAVEGACIÓN -->

                            <div class="w3-row-padding w3-center w3-margin-bottom">
                                <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">
                                <a href="index.php" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">Volver</a>
                            </div>
                        </div>
                    </form>

                    <!-- FIN DEL FORMULARIO -->

                </div>
                 <div class="w3-content">
                     <h3 class="w3-center w3-text-theme">Historial de recargas</h3>

                 <!-- TABLA HISTORIAL DE RECARGAS -->

                     <table class="w3-table-all w3-striped w3-border w3-border-theme w3-small">
                        <thead>
                            <tr class="w3-theme">
                                <th>ID</th>
                                <th>Origen de la recarga</th>
                                <th>Stock anterior</th>
                                <th>Cantidad recargada</th>
                                <th>Precio de compra</th>
                                <th>Stock después</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            $sql = "SELECT * FROM recargas INNER JOIN proveedores ON id_proveedor = proveedor_id WHERE producto_id='" . $productos['id_producto'] . "'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                        echo "<td style='width: 2%;'>" . $row["id_recarga"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["proveedor_id"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["stock_antes"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["recarga"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["pc"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["stock_despues"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["date_add"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "No se han encontrado registros.";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    captarCheckbox();
                </script>
                <?php
                    include '../templates/footerClean.php';
                ?>