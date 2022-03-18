                <?php
                    $titulo = "Crear variedad";
                    include '../templates/headIndex.php';
                    if (isset($_POST['altaButton'])) {
                        $nombre_variedad = $_POST['nombre_variedad'];
                        $descripcion_variedad = $_POST['descripcion_variedad'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "INSERT INTO variedades (nombre_variedad, descripcion_variedad, activo) VALUES ('$nombre_variedad', '$descripcion_variedad', '$activo')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                            echo "<script>location.replace('index.php');</script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                        $conn->close();
                    }
                ?>
                <div class="w3-content">
                    <form accept-charset="utf-8" action="#" method="post" name="altaVariedad" id="altaVariedad" class="w3-theme-l4 w3-round w3-padding">

                        <!--  NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for='nombre_variedad' class="w3-text-theme w3-medium">Variedad</label>
                                <input class='w3-input w3-border w3-round' name='nombre_variedad' id='nombre_variedad' type='text' placeholder='nombre' pattern="[a-zA-Z0-9]+">
                                <small id="info_nombre_variedad"></small>
                            </div>
                        </div>

                        <!-- DESCRIPCION -->

                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_variedad" class="w3-text-theme w3-medium">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_variedad" id="descripcion_variedad" rows="5" placeholder="(Opcional)"></textarea>
                                <small id="info_descripcion_variedad"></small>
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
                                <a href="index.php" class="w3-btn w3-theme w3-round w3-block w3-hover-green">Volver</a>
                            </div>    
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <input type="submit" value="Guardar" name="altaButton" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">
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