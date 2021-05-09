<?php
$titulo = "MOSTRAR CATEGORIA";
include '../templates/header.php';
?>

<?php require_once '../../config/functions.php'; ?>

<?php $categoria = getCategoriasById($_GET['id']);
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">

    </div>
    <hr>
</div>

<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <div class="w3-display-container w3-padding w3-center" style="height: 200px;">
        <div class="w3-display-middle  w3-border w3-round w3-border-theme">
            <div class="w3-cell w3-padding-large w3-center">
                <p><i class="<?php echo $categoria['icono']; ?> w3-text-theme  w3-jumbo"></i></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <p class="w3-text-theme w3-xlarge">Categoría # <span><?php echo $categoria['id']; ?></span></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <p class="w3-text-theme w3-large">Nombre: <span class="w3-text-grey"><?php echo $categoria['nombre']; ?></span></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <p class="w3-text-theme w3-large">Descripción: <span class="w3-text-grey"><?php echo $categoria['descripcion']; ?></span></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <a href="update.php?id=<?php echo $categoria['id'] ?>" class="w3-button w3-theme w3-round">Editar</a>
            </div>
        </div>
    </div>

    <div class="w3-container w3-padding w3-responsive">
        <table class="w3-table w3-striped w3-bordered w3-border w3-border-theme w3-centered">
            <thead>
                <tr class="w3-theme">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Variedad</th>
                    <th>PVC</th>
                    <th>PVP</th>
                    <th>Cantidad</th>
                    <th>Tipo de venta</th>
                    <th>Editar</th>
                    <th>Estado</th>
                </tr>
            </thead>
        </table>
    </div>

</div>

<?php
include '../templates/footer.php';
?>