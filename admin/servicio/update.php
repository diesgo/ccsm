                    <?php
                    $titulo = "Editar servicio";
                    include '../templates/headIndex.php';
                    require '../../config/conexion.php';
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
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">

                        <!--  NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for="nombre" class="w3-text-theme w3-medium">Nombre</label><br>
                                <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $servicio['nombre_servicio']; ?>">
                                <small id="info_nombre"></small>
                            </div>
                        </div>

                        <!-- DESCRIPCIÓN -->

                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_servicio" class="w3-text-theme w3-mediun">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_servicio" id="descripcion_servicio" rows="5"><?php echo $servicio['descripcion_servicio'] ?></textarea>
                                <small id="info_descripcion_servicio"></small>
                            </div>
                        </div>

                        <!-- ACTIVO -->

                        <div class="w3-row">
                            <div class="w3-col w3-padding w3-margin-top">
                                <legend for="activo" class="w3-text-theme w3-medium">Visible</legend>
                                <label class="switch">
                                    <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $variedad['activo'] ?>">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- BOTONES NAVEGACIÓN -->

                        <div class="w3-row w3-padding-32 w3-center">
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <input type="submit" value="Actualizar" name="actualizar" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">
                            </div>
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <a href="index.php" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">Volver</a>
                            </div>
                        </div>
                    </form>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                    include '../templates/footer.php';
                    ?>