                <?php
                    $titulo = 'Listado de productos';
                    include '../templates/headIndex.php';
                ?>
                <input type="text" id="search" onkeyup="searchTableByName()" placeholder="&#x1f50d;&#xfe0e; Search for names.." title="Type in a name" pattern="[a-zA-Z0-9]+" autofocus>
                
                    <table id="list" class="w3-table-all w3-striped w3-border w3-border-theme w3-medium">
                        <thead>
                            <tr class="w3-theme">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Variedad</th>
                                <th>Tipo de servicio</th>
                                <th>Stock</th>
                                <th>En dispensario</th>
                                <th>PVP</th>
                                <th class="w3-center">Activo</th>
                                <th class="w3-center"></th>
                                <th class="w3-center"></th>
                                <th class="w3-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            $sql = "SELECT * FROM productos";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                        echo "<td style='width: 2%;'>" . $row["id_producto"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["nombre_producto"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["categoria_id"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["variedad_id"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["servicio_id"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["cantidad"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["dispensario"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["pvp"] . "</td>";
                                        echo "<td class='w3-center' style='width: 2%'><input type='checkbox' class='activo' value='" . $row['activo'] . "' disabled></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='update.php?id=" . $row['id_producto'] . "'><i class='fas fa-pen w3-medium'></i></a></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='charge.php?id=" . $row['id_producto'] . "'><i class='far fa-balance-scale w3-medium'></i></a></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-red w3-hover-text-orange' href='baja.php?id=" . $row['id_producto'] . "' onclick='warningErase()'><i class='fas fa-trash w3-medium'></i></a>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "No se han encontrado registros.";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                
                <script>
                    captarCheckbox();
                </script>
                <?php
                    include '../templates/footerIndex.php';
                ?>