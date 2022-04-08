                    <?php
                        $titulo = 'Listado de variedades';
                        include '../templates/header.php';
                    ?>
                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <table id="table" class="w3-table-all w3-striped w3-border w3-border-theme w3-medium" style="margin: 0 auto;">
                            <thead>
                                <tr class="w3-theme">
                                    <th>ID</th>
                                    <th>Variedad</th>
                                    <th>Descripción</th>
                                    <th class="w3-center">Activo</th>
                                    <th class="w3-center"></th>
                                    <th class="w3-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                                    $sql = "SELECT * FROM variedades";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                                echo "<td style='width: 2%;'>" . $row["id_variedad"] . "</td>";
                                                echo "<td style='width: 10%'>" . $row["nombre_variedad"] . "</td>";
                                                echo "<td style='width: 10%'>" . $row["descripcion_variedad"] . "</td>";
                                                echo "<td class='w3-center' style='width: 2%'><input type='checkbox' class='activo' value=" . $row['activo'] . " disabled></td>";
                                                echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='update.php?id=" . $row['id_variedad'] . "'><i class='fas fa-pen w3-medium'></i></a></td>";
                                                echo "<td class='w3-center' style='width: 2%'><a class='w3-text-red w3-hover-text-orange' href='baja.php?id=" . $row['id_variedad'] . "'><i class='fas fa-trash w3-medium'></i></a>";
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
                    <div class="w3-container w3-center w3-margin-top">
                        <a class="w3-button w3-theme w3-border w3-border-theme w3-round-large w3-hover-white w3-hover-text-theme w3-margin-top" href="create.php"><i class="fas fa-plus-circle"></i> Nuevo registro</a>
                    </div>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                        include '../templates/footer.php';
                    ?>