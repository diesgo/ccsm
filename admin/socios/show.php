<?php
$titulo = "CCSM | Socio";
include '../templates/header.php';
require_once '../../config/functions.php';
$socios = getSociosById($_GET['id']); ?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-light">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-user-edit"></i> Socio</b></h2>
    </div>
    <div class="w3-half">
    </div>
    <hr>
</div>

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div class="w3-content w3-padding">
        <div class="w3-half w3-margin-top w3-padding w3-border w3-border-theme w3-round">
            <div class="w3-row-padding">
                <div class="w3-col l4 w3-padding-large">
                    <img class="w3-image" id="foto_socio" src="/club/img/s/0.png" alt="">
                </div>
                <div class="w3-col l8">
                    <p class="w3-text-theme w3-xlarge">Socio # <span id="socio_id"><?php echo $socios['id']; ?></span></p>
                    <p class="w3-text-theme w3-large">Nombre: <span class="w3-text-grey" id="socio_nombre"><?php echo $socios['nombre']; ?><?php echo $socios['apellidos'] ?></span></p>
                    <p class="w3-text-theme w3-large">Fecha de nacimiento: <span class="w3-text-grey" id="socio_birth_date"><?php echo $socios['birth']; ?></span></p>
                    <p class="w3-text-theme w3-large">Sexo: <span class="w3-text-grey" id="sex_socio"><?php echo $socios['genero']; ?></span></p>
                    <p class="w3-text-theme w3-large">Saldo: <span class="w3-text-grey" id="saldo_socio"><?php echo $socios['saldo']; ?></span></p>
                    <p class="w3-text-theme w3-large">Nacionalidad: <span class="w3-text-grey" id="pais"><?php echo $socios['pais']; ?></span></p>
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
                    <a href="update.php?id=<?php echo $socios['id'] ?>" class="w3-button w3-theme w3-round">Editar</a>
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