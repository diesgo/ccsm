                    <?php
                    $titulo = "Editar variedad";
                    include '../templates/headIndex.php';
                    require '../../config/conexion.php';
                    $variedad = getVariedadesById($_GET['id_variedad']);
                    if (isset($_POST['actualizar'])) {
                        $id = $variedad['id_variedad'];
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion_variedad'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        $sql = "UPDATE variedades SET nombre_variedad = '" . $nombre . "', descripcion_variedad = '" . $descripcion ."', activo = '" . $activo ."' WHERE id_variedad = " . $id . ";";
                        echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                        echo "<script>location.replace('index.php');</script>";
                        mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                    } else {
                        if (!isset($_POST['id_variedad'])) {
                            $sql = "SELECT min(id_variedad) FROM variedades";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['min(id_variedad)'];
                        } else {
                            $id = $_POST["id_variedad"];
                        }
                        $sql = "SELECT * FROM variedades WHERE id_variedad = '$id'";
                        $result = mysqli_query($conex, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $nombre = $row['nombre_variedad'];
                        $descripcion = $row['descripcion_variedad'];
                        $activo = $row['activo'];
                    }
                    $sql = "SELECT * FROM variedades";
                    $result = mysqli_query($conex, $sql);
                    ?>
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">

                        <!--  NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for="nombre" class="w3-text-theme w3-medium">Nombre</label><br>
                                <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $variedad['nombre_variedad']; ?>">
                                <small id="info_nombre"></small>
                            </div>
                        </div>

                        <!-- DESCRIPCIÓN -->

                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_variedad" class="w3-text-theme w3-mediun">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_variedad" id="descripcion_variedad" rows="5"><?php echo $variedad['descripcion_variedad'] ?></textarea>
                                <small id="info_descripcion_variedad"></small>
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