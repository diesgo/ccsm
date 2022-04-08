                    <?php
                        $titulo = "Crear servicio";
                        include '../templates/header.php';
                        if (isset($_POST['addnew'])) {
                            $nombre_servicio = $_POST['nombre_servicio'];
                            $descripcion_servicio = $_POST['descripcion_servicio'];
                            $activo = isset($_POST['activo']) ? "1" : "0";
                            // Create connection
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "INSERT INTO servicios (nombre_servicio, descripcion_servicio, activo)
                            VALUES ('$nombre_servicio', '$descripcion_servicio', '$activo')";

                            if ($conn->query($sql) === TRUE) {
                                echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                                echo "<script>location.replace('index.php');</script>";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                            $conn->close();
                        }
                    ?>
                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for='nombre_servicio' class="w3-text-theme-dark w3-medium">Servicio</label>
                                    <input class='w3-input w3-border w3-round-large' name='nombre_servicio' id='nombre_servicio' type='text' placeholder='nombre' pattern=[A-Z\sa-z]{3,20} required>
                                    <small id="info_nombre_servicio"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_servicio" class="w3-text-theme-dark w3-medium">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light w3-round-large" name="descripcion_servicio" id="descripcion_servicio" rows="5" placeholder="(Opcional)"></textarea>
                                    <small id="info_descripcion_servicio"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                            </div>

                            <?php
                                include '../templates/nav_btn_add.php';
                            ?>
                        </form>
                    </div>
                    <?php
                        include '../templates/footer.php';
                    ?>