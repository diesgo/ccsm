                    <?php
                    $titulo = 'Servicios';
                    include '../templates/headIndex.php';
                    $servicio = getServicios();
                    ?>
                    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-medium">
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
                            foreach ($servicio as $servicio) :
                            ?>
                            <tr>
                                <td class="w3-center" style="width: 2%;"><?php echo $servicio['id_servicio'] ?></td>
                                <td style="width: 10%"><?php echo $servicio['nombre_servicio'] ?></td>
                                <td style="width: 10%"><?php echo $servicio['descripcion_servicio'] ?></td>
                                <td class="w3-center" style="width: 2%">
                                    <input type="checkbox" class="activo" value="<?php echo $servicio['activo'] ?>" disabled>
                                </td>
                                <td class="w3-center" style="width: 2%">
                                    <a class="w3-text-green w3-hover-text-orange" href="update.php?id_servicio=<?php echo $servicio['id_servicio'] ?>">
                                        <i class="fas fa-pen w3-medium"></i>
                                    </a>
                                </td>
                                <td class="w3-center" style="width: 2%">
                                    <a class="w3-text-red w3-hover-text-orange" href="baja.php?id_servicio=<?php echo $servicio['id_servicio'] ?>">
                                        <i class="fas fa-trash w3-medium"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                    include '../templates/footerIndex.php';
                    ?>