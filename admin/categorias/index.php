<?php
$titulo = 'CATEGORIAS';
include '../templates/header.php';
include '../templates/head_index.php';
?>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
        <thead>
            <tr class="w3-theme">
                <th>ID</th>
                <th>categoría</th>
                <th>Descripción</th>
                <th>Icono</th>
                <th>Editar</th>
                <th>Ver</th>
            </tr>
        </thead>
        <?php
        require_once '../../config/functions.php';
        $categorias = getCategorias();
        foreach ($categorias as $categoria) :
        ?>
            <tr>
                <td style="width: 5%;"><?php echo $categoria['id'] ?></td>
                <td style="width: 20%"><?php echo $categoria['nombre'] ?></td>
                <td style="width: 60%"><?php echo $categoria['descripcion'] ?></td>
                <td style="width: 5%" class="w3-text-theme"><i class="<?php echo $categoria['icono'] ?>"></i></td>
                <td style="width: 5%">
                    <a href="update.php?id=<?php echo $categoria['id'] ?>">
                        <i class="fas fa-pen w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 5%">
                    <a href="show.php?id=<?php echo $categoria['id'] ?>">
                        <i class="fas fa-eye w3-text-theme"></i>
                    </a>
                </td>
            <?php endforeach; ?>
    </table>
</div>

<?php
include '../templates/footer.php';
?>