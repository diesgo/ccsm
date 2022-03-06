<?php
$titulo = 'Categorias';
include '../templates/header.php';
include '../templates/head_index.php';
?>

            <!-- !PAGE CONTENT! -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div class="w3-content">
                    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
                        <thead>
                            <tr class="w3-theme">
                                <th>ID</th>
                                <th>categoría</th>
                                <th>Descripción</th>
                                <th>Icono</th>
                                <th>Activo</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once '../../config/functions.php';
                            $categorias = getCategorias();
                            foreach ($categorias as $categoria) :
                            ?>
                            <tr>
                                <td style="width: 5%;"><?php echo $categoria['id_categoria'] ?></td>
                                <td style="width: 10%"><?php echo $categoria['nombre_categoria'] ?></td>
                                <td style="width: 10%"><?php echo $categoria['descripcion_categoria'] ?></td>
                                <td style="width: 5%" class="w3-text-theme"><?php echo $categoria['icono'] ?></td>
                                <td style="width: 10%"><?php echo $categoria['activo'] ?></td>
                                <td style="width: 2%">
                                    <input type="hidden" name="validation" id="validation" value="si" />
                                    <a class="w3-btn w3-green w3-round" href="update.php?id_categoria=<?php echo $categoria['id_categoria'] ?>">
                                        <i class="fas fa-pen w3-small"></i>
                                    </a>
                                </td>
                                <td style="width: 2%">
                                    <a class="w3-btn w3-red w3-round" href="baja.php?id_categoria=<?php echo $categoria['id_categoria'] ?>">
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