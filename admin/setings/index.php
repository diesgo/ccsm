<?php
$titulo = "Editar roles | CCSM";
include '../templates/header.php';
?>
<?php
require '../../config/conexion.php';
if (isset($_POST['actualizar'])) {

    $color = $_POST['color'];
    $fuente = $_POST['fuente'];

    $sql = "UPDATE settings SET color ='" . $color . "',fuente='" . $fuente . "' WHERE id=1;";
    // echo $sql;

    mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
} else {
    if (!isset($_POST['id'])) {
        $sql = "SELECT min(id) FROM settings";
        $result = mysqli_query($conex, $sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['min(id)'];
    } else {
        $id = $_POST["id"];
    }
    $sql = "SELECT * FROM settings WHERE id='$id'";
    $result = mysqli_query($conex, $sql);
    $row = mysqli_fetch_assoc($result);
    $color = $row['color'];
    $fuente = $row['fuente'];
}
$sql = "SELECT * FROM settings";
$result = mysqli_query($conex, $sql);

?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-light-grey">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-user-edit"></i> Editar socio</b></h2>
    </div>
    <div class="w3-half">
        <a class="w3-right w3-button w3-theme-dark w3-border w3-border-theme-dark w3-round w3-hover-white w3-hover-theme-dark w3-hover-text-theme-dark" href="color.php">+ Añadir esquema de color</a>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-padding-large">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="altaSocio" id="altaSocio">
                <!-- FICHA SOCIO  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 2: ROL Y DESCRIPCIÓN -->
                    <div class="w3-row">
                        <!-- ROL -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="color" class="w3-text-theme">Esquema de color</label>
                            <select name="color" id="color" class="w3-select w3-white">
                                <?php
                                require_once '../../config/functions.php';
                                $settings = getSetingsById(1);
                                ?>
                                <option value=<?php echo $settings['color']; ?>></option>
                                <?php
                                $temas = getTemas();
                                foreach ($temas as $temas) :
                                ?>
                                    <option value=<?php echo $temas['color']; ?>><?php echo $temas['color'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_rol"></small>
                        </div>
                        <!-- DESCRIPCIÓN -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="fuente" class="w3-text-theme">fuente</label>
                            <input class="w3-input w3-border w3-round" name="fuente" id="fuente" type="text" value=<?php echo $fuente ?>>
                            <small id="info_fuente"></small>
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
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>