            <?php
                $titulo = 'Listado de variedades';
                include '../templates/header.php';
                include '../templates/header_index.php';
                $variedades = getVariedades();
            ?>

            <div class="w3-container w3-mobile">
                <table id="grid" class="w3-table w3-striped w3-bordered w3-centered w3-responsive" style="color: #555">
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
                            if (mysqli_num_rows($variedades) > 0) {
                                while ($variedad = mysqli_fetch_assoc($variedades)) {
                                    echo "<tr>";
                                        echo "<td style='width: 2%;'>" . $variedad["id_variedad"] . "</td>";
                                        echo "<td style='width: 10%'>" . $variedad["nombre_variedad"] . "</td>";
                                        echo "<td style='width: 10%'>" . $variedad["descripcion_variedad"] . "</td>";
                                        echo "<td class='w3-center' style='width: 2%'><input type='checkbox' class='activo' value=" . $variedad['activo'] . " disabled></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='update.php?id=" . $variedad['id_variedad'] . "'><i class='fas fa-pen w3-medium'></i></a></td>";
                                        echo "<td class='w3-center' style='width: 2%'><a class='w3-text-red w3-hover-text-orange' href='baja.php?id=" . $variedad['id_variedad'] . "'><i class='fas fa-trash w3-medium'></i></a>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "No se han encontrado registros.";
                            }
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