<?php
$titulo = 'Categorías | CCSM';
include '../templates/heade.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-light-grey">
    <div class="w3-half">
        <h2><b><i class="fa fa-dashboard"></i>Categorías</b></h2>
    </div>
    <div class="w3-half">
        <a class="w3-right w3-button w3-theme-dark w3-border w3-border-theme-dark w3-round w3-hover-white w3-hover-theme-dark w3-hover-text-theme-dark" href="nuevoRol.php">+ Nuevo rol</a>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-64 w3-responsive">
    <table class="w3-table w3-striped w3-bordered w3-border w3-border-theme w3-centered">
        <thead>
            <tr class="w3-theme">
                <th>ID</th>
                <th>categoría</th>
                <th>Descripción</th>
                <th>Editar</th>
                <th>Ver</th>
            </tr>
        </thead>
        <?php
        // index.php
        require_once '../../config/functions.php';
        $categoria = getCategorias();
        ?>
        <?php foreach ($categoria as $categoria) : ?>
            <tr>
                <td style="width: 5%;"><?php echo $categoria['id'] ?></td>
                <td style="width: 10%"><?php echo $categoria['nombre'] ?></td>
                <td style="width: 15%"><?php echo $categoria['descripion'] ?></td>
                <td style="width: 10%">
                    <a href="update.php?id=<?php echo $categoria['id'] ?>">
                        <i class="fas fa-user-edit w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 10%">
                    <a href="show.php?id=<?php echo $categoria['id'] ?>">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            <?php endforeach; ?>
    </table>
</div>

<?php
include '../templates/footer.php';
?>