            <?php
                $titulo = "RECARGAR";
                include '../templates/header.php';
                require '../../config/conexion.php';
                $productos = getProductosById($_GET['id']);
                $sql = "SELECT * FROM productos";
                $result = mysqli_query($conex, $sql);
                if (isset($_POST['update'])) {
                    $id = $productos['id_producto'];
                    $stock = $productos['cantidad'];
                    $origen = $_POST['id_proveedor'];
                    $recarga = $_POST['recarga'];
                    $pc = $_POST['pc'];
                    $stock_total = $stock + $recarga;
                    $sql = "UPDATE productos SET cantidad ='" . $stock_total . "', pc = '" . $pc ."' WHERE id_producto = " . $id . ";";
                    echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                    mysqli_query($conex, $sql);
                    $sql = "INSERT INTO movimientos_stock (proveedor_id, producto_id, stock_antes, recarga, stock_despues, pc)
                    VALUES ('$origen', '$id', '$stock', '$recarga', '$stock_total', '$pc')";
                    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                    if ($conn->query($sql) === TRUE) {
                        echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                        echo "<script>location.replace(./index.php);</script>";
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

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

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
                                            <label for="id_proveedor">Origen</label>
                                            <select name="id_proveedor" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round w3-margin-bottom">
                                                <?php
                                                    $proveedores = getProveedores();
                                                    foreach ($proveedores as $proveedor) :
                                                ?>
                                                <option value=<?php echo $proveedor['id_proveedor']; ?>><?php echo $proveedor['nombre_proveedor'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w3-col w3-padding">
                                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round-xlarge">
                                            <label for="recarga" class="w3-text-theme">Recarga</label>
                                            <input id="recarga" class="w3-input w3-border w3-border-theme-l4 w3-round w3-margin-bottom" type="text" placeholder="gr." name="recarga" pattern=[0-9]{1,20} required>
                                        </div>
                                    </div>

                                    <div class="w3-col w3-padding">
                                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round-xlarge">
                                            <label class="w3-text-theme" for="pc">Precio de compra</label>
                                            <input type="text" name="pc" id="pc" class="w3-input w3-border w3-border-theme-l4 w3-round w3-margin-bottom" placeholder="€" pattern=[0-9.]{1,20} required>
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
                        <h3 class="w3-center w3-text-theme">Historial de recargas <?php echo $productos['nombre_producto']; ?></h3>
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
                                    $sql = "SELECT * FROM movimientos_stock
                                    INNER JOIN proveedores ON id_proveedor = proveedor_id
                                    INNER JOIN destinos ON id_destino = destino_id
                                    WHERE producto_id='" . $productos['id_producto'] . "'
                                    ORDER BY id_movimiento ASC";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                                echo "<td style='width: 2%;'>" . $row["id_movimiento"] . "</td>";
                                                echo "<td>" . $row["nombre_proveedor"] . "</td>";
                                                echo "<td>" . $row["nombre_destino"] . "</td>";
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
                </div>
            </div>
            <script>
                captarCheckbox();
            </script>
            <?php
                include '../templates/footer.php';
            ?>