                    <?php
                    $titulo = 'Proveedores';
                    include '../templates/headIndex.php';
                    $proveedores = getProveedores();
                    ?>

                    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered w3-medium">
                        <thead>
                            <tr class="w3-theme">
                                <th>ID</th>
                                <th>Proveedor</th>
                                <th>Descripción</th>
                                <th class="w3-center">Activo</th>
                                <th class="w3-center"></th>
                                <th class="w3-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($proveedores as $proveedor) :
                            ?>
                            <tr>
                                <td class="w3-center" style="width: 2%;"><?php echo $proveedor['id_proveedor'] ?></td>
                                <td style="width: 10%"><?php echo $proveedor['nombre_proveedor'] ?></td>
                                <td style="width: 10%"><?php echo $proveedor['descripcion_proveedor'] ?></td>
                                <td class="w3-center" style="width: 2%">
                                    <input type="checkbox" class="activo" value="<?php echo $proveedor['activo'] ?>" disabled>
                                </td>
                                <td class="w3-center" style="width: 2%">
                                    <a class="w3-text-green w3-hover-text-orange" href="update.php?id_proveedor=<?php echo $proveedor['id_proveedor'] ?>">
                                        <i class="fas fa-pen w3-medium"></i>
                                    </a>
                                </td>
                                <td class="w3-center" style="width: 2%">
                                    <a class="w3-text-red w3-hover-text-orange" href="baja.php?id_proveedor=<?php echo $proveedor['id_proveedor'] ?>">
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