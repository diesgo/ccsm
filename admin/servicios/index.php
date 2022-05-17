            <?php
                $titulo = 'Servicios';
                include '../templates/header.php';
                include '../templates/header_index.php';
                $servicios = getServicios();
            ?>

            <div class="w3-container w3-mobile">
                <table class="w3-table w3-striped w3-bordered w3-centered w3-responsive" style="color: #555">
                    <thead>
                        <tr class="w3-theme">
                            <th>ID</th>
                            <th>Servicio</th>
                            <th>Descripción</th>
                            <th class="w3-center">Activo</th>
                            <th class="w3-center"></th>
                            <th class="w3-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (mysqli_num_rows($servicios) > 0) {
                                while ($servicio = mysqli_fetch_assoc($servicios)) {?>
                                    <tr>
                                        <td class='w3-center' style='width: 2%;'><?php echo $servicio["id_servicio"] ?></td>
                                        <td style='width: 10%'><?php echo $servicio["nombre_servicio"] ?></td>
                                        <td style='width: 10%'><?php echo $servicio["descripcion_servicio"] ?></td>
                                        <td class='w3-center' style='width: 2%'><input type='checkbox' class='activo' value=<?php echo $servicio["activo"] ?> disabled></td>
                                        <td class='w3-center' style='width: 2%'><a class='w3-text-green w3-hover-text-orange' href='update.php?id=<?php echo $servicio["id_servicio"] ?>'><i class='fas fa-pen w3-medium'></i></a></td>
                                        <td class='w3-center' style='width: 2%'><a class='w3-text-red w3-hover-text-orange' href='baja.php?id=<?php echo $servicio["id_servicio"] ?>'><i class='fas fa-trash w3-medium'></i></a>
                                    </tr>
                                    <?php
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