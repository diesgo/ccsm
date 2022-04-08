            <?php
                $titulo = 'Listado de productos';
                include '../templates/header.php';
            ?>

            <!-- !PAGE CONTENT! -->

            <div class="w3-row-padding">
                <div class="w3-col l10 m10">
                    <input type="text" id="search" onkeyup="searchTableByName()" placeholder="&#x1f50d;&#xfe0e; Search for names.." title="Type in a name" pattern="[a-zA-Z0-9]+" autofocus>
                </div>
                <div class="w3-col l2 m2 w3-padding">
                    <a class="w3-right w3-button w3-theme-d3 w3-round-xxlarge w3-hover-theme" href="create.php">+ New product</a>
                </div>
            </div>

            <div class="w3-container w3-padding-48 w3-responsive">
                <table id="grid" class="w3-table w3-striped w3-bordered w3-centered" style="color: #555">
                    <thead>
                        <tr>
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
                                        echo "<td style='width: 2%;'>" . $row["id_producto"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["nombre_producto"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["nombre_categoria"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["nombre_variedad"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["nombre_servicio"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["cantidad"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["dispensario"] . "</td>";
                                        echo "<td style='width: 10%'>" . $row["pvp"] . "</td>";
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