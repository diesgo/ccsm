                    <?php
                    $titulo = "Crear proveedor";
                    include '../templates/headIndex.php';
                    if (isset($_POST['altaButton'])) {
                        $nombre_proveedor = $_POST['nombre_proveedor'];
                        $descripcion_proveedor = $_POST['descripcion_proveedor'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        // Create connection
                        $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "INSERT INTO proveedores (nombre_proveedor, descripcion_proveedor, activo) VALUES ('$nombre_proveedor', '$descripcion_proveedor', '$activo')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                            echo "<script>location.replace('index.php');</script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                        $conn->close();
                    }
                    ?>
                    <form accept-charset="utf-8" action="#" method="post" name="altasProveedor" id="altasProveedor">

                        <!--  NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for='nombre_proveedor' class="w3-text-theme w3-medium">Proveedor</label>
                                <input class='w3-input w3-border w3-round' name='nombre_proveedor' id='nombre_proveedor' type='text' placeholder='nombre'>
                                <small id="info_nombre_proveedor"></small>
                            </div>
                        </div>

                        <!-- DESCRIPCION -->

                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_proveedor" class="w3-text-theme w3-medium">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_proveedor" id="descripcion_proveedor" rows="5" placeholder="(Opcional)"></textarea>
                                <small id="info_descripcion_proveedor"></small>
                            </div>
                        </div>

                        <!-- ACTIVO -->

                        <div class="w3-row">
                            <div class="w3-col w3-padding w3-margin-top">
                                <legend for="activo" class="w3-text-theme w3-medium">Visible</legend>
                                <label class="switch">
                                    <input class="activo custom" type="checkbox"  name="activo">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- BOTONES NAVEGACIÓN -->

                        <div class="w3-row w3-padding-32 w3-center">
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <input type="submit" value="Guardar" name="altaButton" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">
                            </div>
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <a href="index.php" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">Volver</a>
                            </div>
                        </div>
                    </form>
                    <?php
                    include '../templates/footer.php';
                    ?>