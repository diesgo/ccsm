            <?php
                $titulo = 'Listado de productos';
                include '../templates/header.php';
                include '../templates/header_index.php'; 
            ?>

            <!-- !PAGE CONTENT! -->

            <div class="w3-row-padding">
                <div class="w3-col">
                    <input type="text" id="search" onkeyup="searchTableByName()" placeholder="&#x1f50d;&#xfe0e; Search for names.." title="Type in a name" pattern="[a-zA-Z0-9]+" autofocus>    
                </div>
            </div>

            <div class="w3-container w3-padding-48 w3-responsive">
                <table id="grid" class="w3-table w3-striped w3-bordered w3-responsive" style="color: #555">
                    <thead class="w3-theme">
                        <tr>
                            <th class='w3-center'></i>ID</th>
                            <th onclick="sortTable(1)">Nombre </th>
                            <th onclick="sortTable(2)" class='w3-center'>Categoria </th>
                            <th onclick="sortTable(3)" class='w3-center' >Variedad </th>
                            <th onclick="sortTable(4)"class='w3-center'>Tipo de servicio </th>
                            <th class='w3-center'>Stock</th>
                            <th class='w3-center'>En dispensario</th>
                            <th class='w3-center'>PVP</th>
                            <th class="w3-center">Activo</th>
                            <th class="w3-center"></th>
                            <th class="w3-center"></th>
                            <th class="w3-center"></th>
                            <th class="w3-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            $sql = "SELECT * FROM productos
                            INNER JOIN categorias ON id_categoria = categoria_id
                            INNER JOIN variedades ON id_variedad = variedad_id
                            INNER JOIN servicios ON id_servicio = servicio_id";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                        echo "<td class='w3-center'>" . $row["id_producto"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["nombre_producto"] . "</td>";
                                        echo "<td class='w3-center'>" . $row["nombre_categoria"] . "</td>";
                                        echo "<td class='w3-center'>" . $row["nombre_variedad"] . "</td>";
                                        echo "<td class='w3-center'>" . $row["nombre_servicio"] . "</td>";
                                        echo "<td class='w3-center'>" . $row["cantidad"] . " gr.</td>";
                                        echo "<td class='w3-center'>" . $row["dispensario"] . " gr.</td>";
                                        echo "<td class='w3-center'>" . $row["pvp"] . " €</td>";
                                        echo "<td class='w3-center' style='width: 2%'><input type='checkbox' class='activo' value='" . $row['activo'] . "' disabled></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='update.php?id=" . $row['id_producto'] . "'><i class='fas fa-pen w3-medium'></i></a></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='charge.php?id=" . $row['id_producto'] . "'><i class='fas fa-sign-in-alt w3-medium'></i></a></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='traspaso.php?id=" . $row['id_producto'] . "'><i class='fas fa-sign-out-alt w3-medium'></i></a></td>";
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
            </div>
            <script>
                captarCheckbox();
            </script>
            <?php
                include '../templates/footer.php';
            ?>