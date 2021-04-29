<?php
$titulo = "CCSM | Nuevo socio";
include '../templates/header.php';
?>

<?php
if (isset($_POST['altaButton'])) {
    require_once '../../config/config.php';

    $rol = $_POST['rol'];
    $descripcion = $_POST['descripcion'];

    // Create connection

    $conn =
        new mysqli(
            DBHOST,
            DBUSER,
            DBPWD,
            DBNAME
        );

    // Check connection

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO roles (rol, descripcion)
    VALUES ('$rol', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        echo "Se ha creado un nuevo registro";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>



<!-- Header -->

<div class="w3-container w3-padding-32 w3-light-grey">
    <div class="w3-half">
        <h2><b><i class="fa fa-dashboard"></i>Nuevo socio</b></h2>
    </div>
    <div class="w3-half">
        <!-- <a class="w3-right w3-button w3-theme-dark w3-border w3-border-theme-dark w3-round w3-hover-white w3-hover-theme-dark w3-hover-text-theme-dark" href="nuevoSocio.php">+ New socios</a> -->
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-padding-large">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="#" method="post" name="altaSocio" id="altaSocio">
                <!-- FICHA ROL  -->
                <div class="w3-content w3-padding">
                    <!-- FILA 1: ROL -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for='rol'>Rol</label>
                            <input class='w3-input w3-border w3-round' name='rol' id='rol' type='text' placeholder='Rol'>
                            <small id="info_rol"></small>
                        </div>
                        <!-- APELLIDOS -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="descripcion">Descripción</label>
                            <input class="w3-input w3-border w3-round" name="descripcion" id="descripcion" type="text" placeholder="Descripción">
                            <small id="info_descripcion"></small>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Guardar" name="altaButton" class="w3-button w3-theme w3-round">
                    <input title="Guardar el producto y permanecer en la página actual: ALT+SHIFT+S" />
                    <button type="button" class="w3-button w3-theme w3-round" id="product_form_save_go_to_catalog_btn" data-toggle="pstooltip" title="Guardar y regresar al catálogo: ALT+SHIFT+Q">Ir al catálogo</button>
                    <button type="button" class="w3-button w3-theme w3-round" id="product_form_save_new_btn" data-toggle="pstooltip" title="Guardar y crear un nuevo producto: ALT+SHIFT+P">Añadir nuevo producto</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/fecha.js"></script>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>