<?php
$titulo = "MOSTRAR VARIEDAD";
include '../templates/header.php';
?>

<?php require_once '../../config/functions.php'; ?>

<?php $variedades = getVariedadesById($_GET['id_variedad']); ?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">

    </div>
    <hr>
</div>

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
    <div class="w3-content w3-padding">
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding">
                <div class="w3-col l4 w3-padding-large">

                </div>
                <div class="w3-col l8">
                    <p class="w3-text-theme w3-xlarge">Variedad # <span><?php echo $variedades['id_variedad']; ?></span></p>
                    <p class="w3-text-theme w3-large">Nombre: <span class="w3-text-grey"><?php echo $variedades['nombre_variedad']; ?></span></p>
                </div>
            </div>
        </div>
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding w3-margin-top w3-margin-bottom">
                <div class="w3-col l4">

                </div>
                <div class="w3-col l4">
                    <a href="update.php?id=<?php echo $variedades['id_variedad'] ?>" class="w3-button w3-theme w3-round">Editar</a>
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