<?php
$titulo = "MOSTRAR PRODUCTO";
include '../templates/header.php';
?>
<?php
require_once '../../config/functions.php';
$productos = getProductosById($_GET['id']);
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
    <div class="w3-content w3-padding">
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding">
                <div class="w3-col l4 w3-padding-large">
                    <img class="w3-image" id="foto_socio" src="/club/img/s/0.png" alt="">
                </div>
                <div class="w3-col l8">
                    <p class="w3-text-theme w3-xlarge">Artículo # <span id="id"><?php echo $productos['id']; ?></span></p>
                    <p class="w3-text-theme w3-large">Nombre: <span class="w3-text-grey" id="nombre"><?php echo $productos['nombre']; ?></span></p>
                    <p class="w3-text-theme w3-large">Categoría: <span class="w3-text-grey" id="categoria"><?php echo $productos['categoria']; ?></span></p>
                    <p class="w3-text-theme w3-large">Variedad: <span class="w3-text-grey" id="variedad"><?php echo $productos['variedad']; ?></span></p>
                    <p class="w3-text-theme w3-large">Precio de venta: <span class="w3-text-grey" id="pvp"><?php echo $productos['pvp']; ?></span></p>
                </div>
            </div>
        </div>
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding w3-margin-top w3-margin-bottom">
                <div class="w3-col l4">
                    <input type="text" name="charge" id="charge_socio" style="width: 100%;">
                    <button class="boton w3-margin-top">Cargar</button>
                </div>
                <div class="w3-col l4">
                    <a href="update.php?id=<?php echo $productos['id'] ?>" class="w3-button w3-theme w3-round">Editar</a>
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