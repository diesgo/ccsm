<?php
$titulo = "Editar servicio";
include '../templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></h2>
    </div>
    <div class="w3-half">
        <?php
        $servicio = getServiciosById($_GET['id_servicio']);
        if (isset($_POST['actualizar'])) {
            $id_servicio = $servicio['id_servicio'];
            $nombre_servicio = $_POST['nombre_servicio'];
            $descripcion_servicio = $_POST['descripcion_servicio'];
            $activo = isset($_POST['activo']) ? "1" : "0";
            $sql = "UPDATE servicio SET
             nombre_servicio ='" . $nombre_servicio . "',
             descripcion_servicio = '" . $descripcion_servicio . "',
             activo = '" . $activo . "'
             WHERE id_servicio = " . $id_servicio . ";";
            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Cambios guardados</h3>";
             echo "<script>location.replace('index.php');</script>";
            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
            
        } else {
            if (!isset($_POST['id_servicio'])) {
                $sql = "SELECT min(id_servicio) FROM servicio";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id_servicio = $row['min(id_servicio)'];
            } else {
                $id_servicio = $_POST["id_servicio"];
            }
            $sql = "SELECT nombre_servicio, descripcion_servicio, activo FROM servicio WHERE id_servicio='$id_servicio'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $nombre_servicio = $row['nombre_servicio'];
            $descripcion_servicio = $row['descripcion_servicio'];
        }
        $sql = "SELECT * FROM servicio";
        $result = mysqli_query($conex, $sql);
        ?>
    </div>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 594px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="altaServicio" id="altaServicio">
                <!-- FICHA SOCIO  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 2: ROL Y DESCRIPCIÓN -->
                    <div class="w3-row">
                        <!-- ROL -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="nombre_servicio" class="w3-text-theme w3-medium">Servicio</label><br>
                            <input class='w3-input w3-border w3-round' name='nombre_servicio' id='nombre_servicio' type='text' value=<?php echo $servicio['nombre_servicio'] ?>>
                            <small id="info_nombre_servicio"></small>
                        </div>
                    </div>
                    <div class="w3-row">
                        <!-- DESCRIPCIÓN -->
                        <div class="w3-col m12 l12 s12 w3-padding">
                            <legend for="descripcion_servicio" class="w3-text-theme w3-mediun">Descripción</legend>
                            <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_servicio" id="descripcion_servicio" rows="5"><?php echo $servicio['descripcion_servicio'] ?></textarea>
                            <small id="info_descripcion_servicio"></small>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-col m5 l6 s12 w3-padding">
                            <input class="w3-check" type="checkbox" id="activo" name="activo" value="<?php echo $servicio['activo'] ?>">
                            <label class="w3-text-theme w3-medium" for="activo">Activo</label></p>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="actualizar" name="actualizar" class="w3-button w3-theme w3-round">
                    <a href="index.php" class="w3-button w3-theme w3-round">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>