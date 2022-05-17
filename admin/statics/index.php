                    <?php
                    $titulo = "CCSM | Informes";
                    include '../templates/header.php';
                    ?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

            <div class="w3-container">
                <table class="w3-table-all w3-striped w3-border w3-border-theme w3-small w3-responsive">
                    <thead>
                        <tr class="w3-theme">
                            <th>ID</th>
                            <th>Producto</th>
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
                            INNER JOIN productos ON id_producto = producto_id
                            INNER JOIN proveedores ON id_proveedor = proveedor_id
                            INNER JOIN destinos ON id_destino = destino_id";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                        echo "<td style='width: 2%;'>" . $row["id_movimiento"] . "</td>";
                                        echo "<td>" . $row["nombre_producto"] . "</td>";
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
            <?php
                include '../templates/footer.php';
            ?>