<?php
$titulo = "Roles | CCSM";
include '../templates/header.php';
?>

<?php require_once '../../config/model.php'; ?>

<?php $roles = getRolesById($_GET['id']); ?>
<!-- Header -->

<div class="w3-container w3-padding-32 w3-light-grey">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-user-edit"></i> Editar rol</b></h2>
    </div>
    <div class="w3-half">
        <!-- <a class="w3-right w3-button w3-theme-dark w3-border w3-border-theme-dark w3-round w3-hover-white w3-hover-theme-dark w3-hover-text-theme-dark" href="nuevoSocio.php">+ New socios</a> -->
    </div>
    <hr>
</div>

<div id="ficha_socio" class="w3-container w3-padding w3-margin-bottom">
    <div class="w3-content w3-padding">
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding">
                <div class="w3-col l4 w3-padding-large">
                    <img class="w3-image" id="foto_socio" src="/club/img/s/0.png" alt="">
                </div>
                <div class="w3-col l8">
                    <p class="w3-text-theme w3-xlarge">Rol # <span id="socio_id"><?php echo $roles['id']; ?></span></p>
                    <p class="w3-text-theme w3-large">Nombre: <span class="w3-text-grey" id="socio_nombre"><?php echo $roles['rol']; ?></span></p>
                    <p class="w3-text-theme w3-large">Descripción: <span class="w3-text-grey" id="socio_birth_date"><?php echo $roles['descripcion']; ?></span></p>
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
                    <a href="update.php?id=<?php echo $roles['id'] ?>" class="w3-button w3-theme w3-round">Editar</a>
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