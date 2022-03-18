                    <?php
                    $titulo = 'Emojis';
                    include '../templates/headIndex.php';
                    $iconos = getIconos();
                    ?>
                    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    include '../templates/footerIndex.php';
                    ?>