                    <?php
                    $titulo = 'Emojis';
                    include '../templates/header.php';
                    $iconos = getIconos();
                    ?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <table id="grid" class="w3-table w3-striped w3-bordered w3-centered w3-responsive" style="color: #555">
                             <thead>    
                                <tr class="w3-theme">
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>icono</th>
                                    <th>Código</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($iconos as $icono) :
                                ?>
                                <tr>
                                    <td><?php echo $icono['id_icono'] ?></td>
                                    <td><?php echo $icono['nombre_icono'] ?></td>
                                    <td     class="w3-large"><i class="<?php echo $icono['icono'] ?>""></i></td>
                                    <td class="w3-large"><?php echo $icono['icono'] ?></code></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    include '../templates/footer.php';
                    ?>