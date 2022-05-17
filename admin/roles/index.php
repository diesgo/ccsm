                    <?php
                    $titulo = 'Listado de roles';
                    include '../templates/header.php';
                    $roles = getRoles();
                    ?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-container">
                    <div class="w3-display-container" style="height:60px;">
                    <h2 id="title" class="w3-display-left w3-text-theme"><b><?php echo $titulo ?></b></h2>
                    <a class="w3-display-right w3-button w3-blue w3-round-large w3-hover-green w3-margin-top " href="create.php"><i class="fas fa-plus-circle"></i> Nuevo registro</a>
                    </div>
                </div>
            </div>

                    <div class="w3-container w3-mobile">
                        <table id="grid" class="w3-table w3-striped w3-bordered w3-centered w3-responsive" style="color: #555">
                            <thead>
                                <tr class="w3-theme">
                                    <th>ID</th>
                                    <th>Rol</th>
                                    <th>Descripción</th>
                                    <th class="w3-center"></th>
                                    <th class="w3-center"></th>
                                    <th class="w3-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($roles as $rol) {
                                ?>
                                <tr>
                                    <td class="w3-center" style="width: 2%;"><?php echo $rol['id_rol'] ?></td>
                                    <td style="width: 10%"><?php echo $rol['nombre_rol'] ?></td>
                                    <td style="width: 10%"><?php echo $rol['descripcion_rol'] ?></td>
                                    <td class="w3-center" style="width: 2%">
                                        <input type="checkbox" class="activo" value="<?php echo $rol['activo'] ?> " disabled>
                                    </td>
                                    <td class="w3-center" style="width: 2%">
                                        <a class="w3-text-green w3-hover-text-orange" href="update.php?id=<?php echo $rol['id_rol'] ?>">
                                            <i class="fas fa-pen w3-medium"></i>
                                        </a>
                                    </td>
                                    <td class="w3-center" style="width: 2%">
                                        <a class="w3-text-red w3-hover-text-orange" href="baja.php?id=<?php echo $rol['id_rol'] ?>">
                                            <i class="fas fa-trash w3-medium"></i>
                                        </a>
                                    </td>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                        include '../templates/footer.php';
                    ?>