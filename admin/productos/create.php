                <?php
                    $titulo = "Nuevo registro";
                    include '../templates/headIndex.php';
                    if (isset($_POST['create'])) {
                        $nombre = $_POST['nombre'];
                        $servicio = $_POST['servicio'];
                        $categoria = $_POST['categoria'];
                        $variedad = $_POST['variedad'];
                        $activo = isset($_POST['activo']) ? "1" : "0";

                        // Create connection

                        $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

                        // Check connection

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "INSERT INTO productos (nombre_producto, categoria_id, variedad_id, servicio_id, activo)
                        VALUES ('$nombre', '$categoria', '$variedad',   '$servicio', '$activo')";

                        if ($conn->query($sql) === TRUE) {
                            echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                            // echo "<script>location.replace('index.php');</script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                        $conn->close();
                    }
                 ?>

                <!-- !PAGE CONTENT! -->

                <div class="w3-container w3-padding w3-responsive" style="min-height: 745px;">

                    <div class="w3-container">
                        <div style="width: 40%; margin: 0 auto;" class="w3-mobile">
                            <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l4 w3-round w3-padding">

                                <!-- FIRST ROW
                                Column on small devices -->

                                <div class="w3-row">

                                    <!--NOMBRE -->

                                    <div class="w3-col l6 m6 s12 w3-padding w3-margin-top">
                                        <label for='nombre' class="w3-text-theme w3-medium">Nombre</label>
                                        <input class="w3-input w3-border w3-round" name="nombre" id="nombre" type="text" placeholder="Nombre / Name" onkeyup="checkName('nombre');" required>
                                    </div>

                                    <!-- SERVICIO -->

                                    <div class="w3-col l6 m6 s12 w3-padding w3-margin-top">
                                         <label for="servicio" class="w3-text-theme w3-medium">Tipo de servicio</label>
                                        <select name="servicio" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round" onchange="service();" require>
                                            <option value="">Selecciona...</option>
                                            <?php
                                                $servicios = getServicios();
                                                foreach ($servicios as $servicio) :
                                            ?>
                                            <option value=<?php echo $servicio['id_servicio']; ?>><?php echo $servicio['nombre_servicio'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>

                                <!-- SECOND ROW
                                Column on small devices -->

                                <div class="w3-row">

                                    <!--CATEGORÍA -->

                                    <div class="w3-col l6 m6 s12 w3-padding w3-margin-top">
                                        <label for="categoria" class="w3-text-theme w3-medium">Categoría</label>
                                        <select name="categoria" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round" require>
                                            <option value="">Selecciona...</option>
                                            <?php
                                                $categorias = getCategorias();
                                                foreach ($categorias as $categoria) :
                                            ?>
                                            <option value=<?php echo $categoria['id_categoria']; ?>><?php echo $categoria['nombre_categoria'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!--VARIEDAD -->

                                    <div id="vari" class="w3-col l6 m6 s12 w3-padding w3-margin-top w3-hide">
                                        <label for="variedad" class="w3-text-theme w3-medium">Variedad</label>
                                        <select name="variedad" class="w3-select w3-white w3-round">
                                            <?php
                                                $variedades = getVariedades();
                                                foreach ($variedades as $variedad) :
                                            ?>
                                            <option value=<?php echo $variedad['id_variedad']; ?>><?php echo $variedad['nombre_variedad'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <script>
                                        service();
                                    </script>

                                </div>

                                <!-- THIRD ROW
                                Column on small devices -->

                                <div class="w3-row">

                                    <!-- ACTIVO -->

                                    <div class="w3-col w3-padding w3-margin-top">
                                        <legend for="activo" class="w3-text-theme w3-medium">Visible</legend>
                                        <label class="switch">
                                            <input class="activo custom" type="checkbox"  name="activo">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                </div>

                                <!-- BOTONES DE NAVEGACIÓN -->

                                <div class="w3-row w3-padding-32 w3-center">
                                    <div class="w3-col l6 m6 s12 w3-padding-large">
                                        <a href="index.php" class="w3-btn w3-theme w3-round w3-block w3-hover-green">Volver</a>
                                    </div>    
                                    <div class="w3-col l6 m6 s12 w3-padding-large">
                                        <input type="submit" value="Guardar" name="create" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <?php
                    include '../templates/footerClean.php';
                ?>