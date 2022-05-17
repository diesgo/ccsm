                    <?php
                        $titulo = 'Usuarios';
                        include '../templates/header.php';
                        include '../templates/header_index.php';
                    ?>

                    <!-- !PAGE CONTENT! -->

                    
                        <div class="w3-container w3-mobile" >
                        <table id="grid" class="w3-table w3-striped w3-bordered w3-centered w3-responsive" style="color: #555">
                                <thead>
                                    <tr class="w3-theme">
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>email</th>
                                        <th>Activo</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once '../../config/functions.php';
                                    $users = getUsers();
                                    foreach ($users as $user) :
                                    ?>
                                    <tr>
                                        <td style="width: 5%;"><?php echo $user['id_user'] ?></td>
                                        <td style="width: 10%"><?php echo $user['username'] ?></td>
                                        <td style="width: 10%"><?php echo $user['email'] ?></td>
                                        <td style="width: 10%"><?php echo $user['activo'] ?></td>
                                        <td style="width: 2%">
                                            <input type="hidden" name="validation" id="validation" value="si" />
                                            <a class="w3-btn w3-green w3-round" href="update.php?id_user=<?php echo $user['id_user'] ?>">
                                                <i class="fas fa-pen w3-small"></i>
                                            </a>
                                        </td>
                                        <td style="width: 2%">
                                            <a class="w3-btn w3-red w3-round" href="baja.php?id_servicio=<?php echo $user['id_user'] ?>">
                                                <i class="fas fa-trash w3-small"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    

                    <?php
                        include '../templates/footer.php';
                    ?>