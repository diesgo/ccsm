<?php
$titulo = "EDITAR ROL";
include '../templates/header.php';
?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        $roles = getRolesById($_GET['id']);
        if (isset($_POST['actualizar'])) {
            $id = $roles['id_rol'];
            $nombre = $_POST['rol'];
            $descripcion = $_POST['descripcion'];
            $sql = "UPDATE roles SET rol ='" . $nombre . "',descripcion='" . $descripcion . "' WHERE id=" . $id . ";";
            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id'])) {
                $sql = "SELECT min(id_rol) FROM roles";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id_rol)'];
            } else {
                $id = $_POST["id"];
            }
            $sql = "SELECT rol, descripcion FROM roles WHERE id_rol='$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $nombre = $row['rol'];
            $descripcion = $row['descripcion'];
        }
        $sql = "SELECT * FROM roles";
        $result = mysqli_query($conex, $sql);
        ?>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-padding-large" style="min-height: 616px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="altaSocio" id="altaSocio" class="w3-theme-l4 w3-round w3-padding">
                <!-- FICHA SOCIO  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 2: ROL Y DESCRIPCIÓN -->
                    <div class="w3-row">
                        <!-- ROL -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="nombre" class="w3-text-theme">Categoria</label><br>
                            <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value=<?php echo $roles['rol'] ?>>
                            <small id="info_rol"></small>
                        </div>
                        <!-- DESCRIPCIÓN -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="descripcion" class="w3-text-theme">Descripción</label>
                            <input class="w3-input w3-border w3-round" name="descripcion" id="descripcion" type="text" value=<?php echo $roles['descripcion'] ?>>
                            <small id="info_descripcion"></small>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-theme w3-round">
                    <a href="index.php" class="w3-button w3-theme w3-round">Volver</a>
                </div>
                <!-- BOTONES DE NAVEGACION -->
                                        <div class="w3-row w3-padding-32 w3-center">
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <a href="index.php" class="w3-btn w3-theme w3-round w3-hover-green w3-block">Volver</a>
                            </div>
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <input type="submit" value="Actualizar" name="actualizar" class="w3-btn w3-theme w3-round w3-hover-orange w3-block">
                            </div>
                        </div>
            </form>
        </div>
    </div>
</div>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>