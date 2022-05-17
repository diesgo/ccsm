                    <?php
                        $titulo = "Crear variedad";
                        include '../templates/header.php';
                        if (isset($_POST['addnew'])) {
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

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for='nombre_variedad' class="w3-text-theme-dark w3-medium">Variedad</label>
                                    <input class='w3-input w3-border w3-round-large' name='nombre_variedad' id='nombre_variedad' type='text' placeholder='nombre' pattern=[A-Z\sa-z]{3,20} required>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_variedad" class="w3-text-theme-dark w3-medium">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light w3-round-large" name="descripcion_variedad" id="descripcion_variedad" rows="5" placeholder="(Opcional)"></textarea>
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
                    <script>
                        captarCheckbox();   
                    </script>
                    <?php
                        include '../templates/footer.php';
                    ?>