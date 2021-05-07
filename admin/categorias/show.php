<?php
$titulo = "MOSTRAR CATEGORIA";
include '../templates/header.php';
?>

<?php require_once '../../config/functions.php'; ?>

<?php $categoria = getCategoriasById($_GET['id']); ?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-eye"></i> <?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
    </div>
    <hr>
</div>

<div id="ficha_categoria" class="w3-container w3-padding w3-margin-bottom" style="min-height: 570px;">
    <div class="w3-content w3-padding">
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding">
                <div class="w3-col l4 w3-padding-large">
                </div>
                <div class="w3-col l8">
                    <p class="w3-text-theme w3-xlarge">Categoría # <span><?php echo $categoria['id']; ?></span></p>
                    <p class="w3-text-theme w3-large">Nombre: <span class="w3-text-grey"><?php echo $categoria['nombre']; ?></span></p>
                    <p class="w3-text-theme w3-large">Descripción: <span class="w3-text-grey"><?php echo $categoria['descripcion']; ?></span></p>
                </div>
            </div>
        </div>
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding w3-margin-top w3-margin-bottom">
                <div class="w3-col l4">
                    <!-- <input type="text" name="charge" id="charge_socio" style="width: 100%;">
                    <button class="boton w3-margin-top">Cargar</button> -->
                </div>
                <div class="w3-col l4">
                    <a href="update.php?id=<?php echo $categoria['id'] ?>" class="w3-button w3-theme w3-round">Editar</a>
                </div>
                <div class="w3-col l4">
                    <button class="boton">Añadir <br> comentario</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../templates/footer.php';
?>