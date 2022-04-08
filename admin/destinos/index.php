                <?php
                    $titulo = 'Destinos';
                    include '../templates/header.php';
                    $destino = getDestinos();
                ?>
                    <div class="w3-container" style="width:40%; margin: 0 auto;">
                        <table class="w3-table-all w3-striped w3-border w3-border-theme w3-medium"> 
                            <thead>
                                <tr class="w3-theme">
                                    <th>ID</th>
                                    <th>Destino</th>
                                    <th>Descripción</th>
                                    <th class="w3-center">Activo</th>
                                    <th class="w3-center"></th>
                                    <th class="w3-center"></th>
                                </tr>   
                            </thead>
                            <tbody>
                                <?php
                                $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                                $sql = "SELECT * FROM destinos";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                            echo "<td style='width: 2%;'>" . $row["id_destino"] . "</td>";
                                            echo "<td style='width: 10%'>" . $row["nombre_destino"] . "</td>";
                                            echo "<td style='width: 10%'>" . $row["descripcion_destino"] . "</td>";
                                            echo "<td class='w3-center' style='width: 2%'><input type='checkbox' class='activo' value=" . $row['activo'] . " disabled></td>";
                                            echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='update.php?id=" . $row['id_destino'] . "'><i class='fas fa-pen w3-medium'></i></a></td>";
                                            echo "<td class='w3-center' style='width: 2%'><a class='w3-text-red w3-hover-text-orange' href='baja.php?id=" . $row['id_destino'] . "'><i class='fas fa-trash w3-medium'></i></a>";
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