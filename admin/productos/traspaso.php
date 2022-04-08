            <?php
                $titulo = "Traspasar";
                include '../templates/header.php';
                $productos = getProductsById($_GET['id']);
                    require '../../config/conexion.php';
                    $sql = "SELECT * FROM productos";
                    $result = mysqli_query($conex, $sql);
                    if (isset($_POST['update'])) {
                        $id = $productos['id_producto'];
                        $stock = $productos['cantidad'];
                        $destino = $_POST['destino'];
                        $retirada = $_POST['retirada'];
                        $stock_total = $stock - $retirada;
                        $sql = "UPDATE productos SET cantidad ='" . $stock_total . "' WHERE id_producto = " . $id . ";";
                        echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                        mysqli_query($conex, $sql);
                        $sql = "INSERT INTO movimientos_stock  (destino_id, producto_id, stock_antes, retirada, stock_despues)
                        VALUES ('$destino', '$id', '$stock', '$retirada', '$stock_total')";
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

            <div class="w3-container">
                <div class="w3-row">
                    <div class="w3-col l4 m4 w3-padding">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="chargeProduct" id="chargeProduct" class="w3-theme-l4 w3-round-xlarge w3-padding">
                            <div class="w3-content w3-padding">
                                <div class="w3-row">

                                    <div class="w3-col l6 m6 w3-padding">
                                        <p class="w3-text-theme">Stock Actual: <span class="w3-text-grey"><b><?php echo $productos['cantidad']; ?></b> gr.</span></p>
                                    </div>
                                    <div class="w3-col l6 m6 w3-padding">
                                        <p class="w3-text-theme">En dispensario: <span class="w3-text-grey"><b><?php echo $productos['dispensario']; ?></b> gr.</span></p>
                                    </div>

                                    <div class="w3-col w3-padding">
                                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round-xlarge">
                                            <label class="w3-text-theme" for="destino">Destino</label>
                                            <select name="destino" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round w3-margin-bottom">
                                                <?php
                                                    $destinos = getDestinos();
                                                    foreach ($destinos as $destino) :
                                                ?>
                                                <option value=<?php echo $destino['id_destino']; ?>><?php echo $destino['nombre_destino'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w3-col w3-padding">
                                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round-xlarge">
                                            <label for="retirada" class="w3-text-theme">Retirar</label>
                                            <input id="retirada" class="w3-input w3-border w3-border-theme-l4 w3-round w3-margin-bottom" type="text" placeholder="gr." name="retirada" value="" required>
                                        </div>
                                    </div>
                                    
                                    <?php
                                        include '../templates/nav_btn_upd.php';
                                    ?>
                                </div>
                                <script>
                                    let a = document.getElementById('addDisp');
                                </script>
                            </div>
                        </form>
                    </div>
                    <div class="w3-col l8 m8">
                         <h3 class="w3-center w3-text-theme">Historial de movimientos</h3>

                        <!-- TABLA HISTORIAL DE MOVIMIENTOS DE STOCK -->

                        <table class="w3-table-all w3-striped w3-border w3-border-theme w3-small">
                            <thead>
                                <tr class="w3-theme">
                                    <th>ID</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Stock anterior</th>
                                    <th>Cantidad recargada</th>
                                    <th>Precio de compra</th>
                                    <th>Cantidad retirada</th>
                                    <th>Stock después</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                                $sql = "SELECT * FROM movimientos_stock WHERE producto_id='" . $productos['id_producto'] . "'";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                            echo "<td style='width: 2%;'>" . $row["id_movimiento"] . "</td>";
                                            echo "<td>" . $row["proveedor_id"] . "</td>";
                                            echo "<td>" . $row["destino_id"] . "</td>";
                                            echo "<td>" . $row["stock_antes"] . "</td>";
                                            echo "<td>" . $row["recarga"] . "</td>";
                                            echo "<td>" . $row["pc"] . "</td>";
                                            echo "<td>" . $row["retirada"] . "</td>";
                                            echo "<td>" . $row["stock_despues"] . "</td>";
                                            echo "<td>" . $row["date_add"] . "</td>";
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
                </div>
            </div>
            <?php
                include '../templates/footer.php';
            ?>