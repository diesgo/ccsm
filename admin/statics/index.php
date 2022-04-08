                    <?php
                    $titulo = "CCSM | Informes";
                    include '../templates/header.php';
                    ?>
                    <div class="w3-container">
                        <div class="w3-half">
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
                                    $sql = "SELECT * FROM movimientos_stock";
                                    // INNER JOIN origenes ON id_origen = origen_id
                                    // INNER JOIN destinos ON id_destino = destino_id
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
                        <div class="w3-half"></div>
                    </div>

<?php
include '../templates/footer.php';
?>