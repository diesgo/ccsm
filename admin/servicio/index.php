<?php
$titulo = 'Servicios';
include '../templates/header.php';
include '../templates/head_index.php';
?>

            <!-- !PAGE CONTENT! -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div class="w3-content">
                    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered w3-medium">
                        <thead>
                            <tr class="w3-theme">
                                <th>ID</th>
                                <th>Servicio</th>
                                <th>Descripción</th>
                                <th>Activo</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once '../../config/functions.php';
                            $servicio = getServicios();
                            foreach ($servicio as $servicio) :
                            ?>
                            <tr>
                                <td style="width: 5%;"><?php echo $servicio['id_servicio'] ?></td>
                                <td style="width: 10%"><?php echo $servicio['nombre_servicio'] ?></td>
                                <td style="width: 10%"><?php echo $servicio['descripcion_servicio'] ?></td>
                                <td style="width: 10%"><?php echo $servicio['activo'] ?></td>
                                <td style="width: 2%">
                                    <input type="hidden" name="validation" id="validation" value="si" />
                                    <a class="w3-btn w3-green w3-round" href="update.php?id_servicio=<?php echo $servicio['id_servicio'] ?>">
                                        <i class="fas fa-pen w3-small"></i>
                                    </a>
                                </td>
                                <td style="width: 2%">
                                    <a class="w3-btn w3-red w3-round" href="baja.php?id_servicio=<?php echo $servicio['id_servicio'] ?>">
                                        <i class="fas fa-trash w3-small"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

<?php
include '../templates/footer.php';
?>