                <?php
                    $titulo = "Editar categoria";
                    include '../templates/headIndex.php';
                    require '../../config/conexion.php';
                    $categoria = getCategoriasById($_GET['id']);
                    if (isset($_POST['actualizar'])) {
                        $id = $categoria['id_categoria'];
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion_categoria'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        $sql = "UPDATE categorias SET nombre_categoria = '" . $nombre . "', descripcion_categoria = '" . $descripcion ."', activo = '" . $activo ."' WHERE id_categoria = " . $id . ";";
                        echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                        echo "<script>location.replace('index.php');</script>";
                        mysqli_query($conex, $sql)
                         or die("Error al ejecutar la consulta");
                    } else {
                        if (!isset($_POST['id_categoria'])) {
                            $sql = "SELECT min(id_categoria) FROM categorias";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['min(id_categoria)'];
                        } else {
                            $id = $_POST["id_categoria"];
                        }
                        $sql = "SELECT * FROM categorias WHERE id_categoria = '$id'";
                        $result = mysqli_query($conex, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $nombre = $row['nombre_categoria'];
                        $descripcion = $row['descripcion_categoria'];
                        $activo = $row['activo'];
                    }
                    $sql = "SELECT * FROM categorias";
                    $result = mysqli_query($conex, $sql);
                ?>
                <div class="w3-content">
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario" class="w3-theme-l4 w3-round w3-padding">

                        <!-- NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for="nombre" class="w3-text-theme w3-medium">Nombre</label><br>
                                <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $categoria['nombre_categoria']; ?>" pattern="[a-zA-Z0-9]+">
                                <small id="info_nombre"></small>
                            </div>
                        </div>

                        <!-- DESCRIPCIÓN -->
                                
                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_categoria" class="w3-text-theme w3-mediun">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_categoria" id="descripcion_categoria" rows="5"><?php echo $categoria['descripcion_categoria'] ?></textarea>
                                <small id="info_descripcion_categoria"></small>
                            </div>
                        </div>

                        <!-- ACTIVO -->

                        <div class="w3-row">
                            <div class="w3-col w3-padding w3-margin-top">
                                <legend for="activo" class="w3-text-theme w3-medium">Visible</legend>
                                <label class="switch">
                                    <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $categoria['activo'] ?>">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- BOTONES NAVEGACIÓN -->

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
                <script>
                    captarCheckbox();
                </script>
                <?php
                    include '../templates/footerClean.php';
                ?>