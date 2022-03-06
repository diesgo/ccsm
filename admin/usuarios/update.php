<?php
$titulo = "EDITAR SERVICIOS";
include '../templates/header.php';
require "../../conex.php";
?>

            <!-- Header -->
            
            <div class="w3-container w3-padding-32 w3-theme-l4">
                <div class="w3-half">
                    <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
                <div class="w3-half">
                    <?php
                    $servicio = getServiciosById($_GET['id_servicio']);
                    if (isset($_POST['actualizar'])) {
                        $id = $servicio['id_servicio'];
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion_servicio'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        $sql = "UPDATE servicio SET nombre_servicio = '" . $nombre . "', descripcion_servicio = '" . $descripcion ."', activo = '" . $activo ."' WHERE id_servicio = " . $id . ";";
                        echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                        echo "<script>location.replace('index.php');</script>";
                        mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                    } else {
                        if (!isset($_POST['id_servicio'])) {
                            $sql = "SELECT min(id_servicio) FROM servicio";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['min(id_servicio)'];
                        } else {
                            $id = $_POST["id_servicio"];
                        }
                        $sql = "SELECT * FROM servicio WHERE id_servicio = '$id'";
                        $result = mysqli_query($conex, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $nombre = $row['nombre_servicio'];
                        $descripcion = $row['descripcion_servicio'];
                        $activo = $row['activo'];
                    }
                    $sql = "SELECT * FROM servicio";
                    $result = mysqli_query($conex, $sql);

                    ?>
                </div>
                
            </div>

            <!-- !PAGE CONTENT! -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">
                            
                            <!-- FICHA SERVICIO  -->
                            
                            <div class="w3-content">
                                
                                <!-- NOMBRE -->

                                <div class="w3-row">
                                    <div class="w3-col m6 l6 s12 w3-margin-bottom">
                                        <label for="nombre" class="w3-text-theme">Nombre</label><br>
                                        <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $servicio['nombre_servicio']; ?>">
                                        <small id="info_nombre"></small>
                                    </div>
                                </div>

                                <!-- DESCRIPCIÓN -->
                                
                                <div class="w3-row">
                                    <div class="w3-col m12 l12 s12 w3-margin-top w3-margin-bottom">
                                        <legend for="descripcion_servicio" class="w3-text-theme w3-mediun">Descripción</legend>
                                        <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_servicio" id="descripcion_servicio" rows="5"><?php echo $servicio['descripcion_servicio'] ?></textarea>
                                        <small id="info_descripcion_servicio"></small>
                                    </div>
                                </div>

                                <!-- ACTIVO -->

                                <div class="w3-row">
                                    <div class="w3-col m5 l6 s12 w3-margin-top">
                                        <input id="activo" class="w3-check" type="checkbox"  name="activo" value="<?php echo $servicio['activo']?>">
                                        <label class="w3-text-theme w3-medium" for="activo">Activo</label></p>
                                    </div>
                                </div>
                            </div>
                            <script>
                                var check= document.getElementById('activo');
                                console.log(check);
                                if (check.value == 1) {
                                    check.setAttribute('checked','');                                    
                                }
                            </script>

                            <!-- BOTONES DE NAVEGACIÓN -->

                            <div class="w3-content">
                                <div class="w3-row w3-padding-32 w3-center w3-margin-top">
                                    <a href="index.php" class="w3-button w3-theme w3-round w3-left">Volver</a>
                                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-green w3-round w3-right">
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