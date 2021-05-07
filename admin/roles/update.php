<?php
$titulo = "Editar roles";
include '../templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-edit"></i> <?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
    </div>
    <hr>
</div>
<div class="w3-container">
    <?php
    require '../../config/functions.php';
    $roles = getCategoriasById($_GET['id']);
    require "../../config/conexion.php";

    if (isset($_POST['actualizar'])) {

        $id = $roles['id'];
        $rol = $_POST['rol'];
        $descripcion = $_POST['descripcion'];

        $sql = "UPDATE roles SET rol ='" . $rol . "',descripcion='" . $descripcion . "' WHERE id=" . $id . ";";
        echo $sql;

        mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
    } else {
        if (!isset($_POST['id'])) {
            $sql = "SELECT min(id) FROM roles";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['min(id)'];
        } else {
            $id = $_POST["id"];
        }
        $sql = "SELECT * FROM roles WHERE id='$id'";
        $result = mysqli_query($conex, $sql);
        $row = mysqli_fetch_assoc($result);
        $rol = $row['rol'];
        $descripcion = $row['descripcion'];
    }
    $sql = "SELECT * FROM roles";
    $result = mysqli_query($conex, $sql);
    ?>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-padding-large">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">
                <!-- FICHA SOCIO  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 2: ROL Y DESCRIPCIÓN -->
                    <div class="w3-row">
                        <!-- ROL -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="rol" class="w3-text-theme">Rol</label><br>
                            <input class='w3-input w3-border w3-round' name='rol' id='rol' type='text' value=<?php echo $row['rol']; ?>>
                            <small id="info_roles"></small>
                        </div>
                        <!-- DESCRIPCIÓN -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="descripcion" class="w3-text-theme">Descripción</label>
                            <textarea name="descripcion" id="descripcion" cols="30" rows="10">
                                <?php echo $row['descripcion']; ?>
                            </textarea>
                            <input class="w3-input w3-border w3-round" name="descripcion" id="descripcion" type="text" value=<?php echo $row['descripcion']; ?>>
                            <small id="info_descripcion"></small>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-theme w3-round">
                    <!-- <button type="button" class="w3-button w3-theme w3-round" id="product_form_save_go_to_catalog_btn" data-toggle="pstooltip" title="Guardar y regresar al catálogo: ALT+SHIFT+Q">Ir al catálogo</button>
                    <button type="button" class="w3-button w3-theme w3-round" id="product_form_save_new_btn" data-toggle="pstooltip" title="Guardar y crear un nuevo producto: ALT+SHIFT+P">Añadir nuevo producto</button> -->
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