                    <?php
                    $titulo = 'Listado de variedades';
                    include '../templates/headIndex.php';
                    $variedades = getVariedades();
                    ?>
                    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-medium">
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
                            foreach ($variedades as $variedad) :
                            ?>
                            <tr>
                                <td class="w3-center" style="width: 2%;"><?php echo $variedad['id_variedad'] ?></td>
                                <td style="width: 10%"><?php echo $variedad['nombre_variedad'] ?></td>
                                <td style="width: 10%"><?php echo $variedad['descripcion_variedad'] ?></td>
                                <td class="w3-center" style="width: 2%">
                                    <input type="checkbox" class="activo" value="<?php echo $variedad['activo'] ?>" disabled>
                                </td>
                                <td class="w3-center" style="width: 2%">
                                    <a class="w3-text-green w3-hover-text-orange" href="update.php?id_variedad=<?php echo $variedad['id_variedad'] ?>">
                                        <i class="fas fa-pen w3-medium"></i>
                                    </a>
                                </td>
                                <td class="w3-center" style="width: 2%">
                                    <a class="w3-text-red w3-hover-text-orange" href="baja.php?id_variedad=<?php echo $variedad['id_variedad'] ?>">
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