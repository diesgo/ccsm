<?php
$titulo = 'Proveedores';
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
                                <th>Proveedor</th>
                                <th>Descripción</th>
                                <th>Activo</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once '../../config/functions.php';
                            $proveedores = getProveedores();
                            foreach ($proveedores as $proveedor) :
                            ?>
                            <tr>
                                <td style="width: 5%;"><?php echo $proveedor['id_proveedor'] ?></td>
                                <td style="width: 10%"><?php echo $proveedor['nombre_proveedor'] ?></td>
                                <td style="width: 10%"><?php echo $proveedor['descripcion_proveedor'] ?></td>
                                <td style="width: 10%"><?php echo $proveedor['activo'] ?></td>
                                <td style="width: 2%">
                                    <input type="hidden" name="validation" id="validation" value="si" />
                                    <a class="w3-btn w3-green w3-round" href="update.php?id_proveedor=<?php echo $proveedor['id_proveedor'] ?>">
                                        <i class="fas fa-pen w3-small"></i>
                                    </a>
                                </td>
                                <td style="width: 2%">
                                    <a class="w3-btn w3-red w3-round" href="baja.php?id_proveedor=<?php echo $proveedor['id_proveedor'] ?>">
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