                    <?php
                        $titulo = "Nuevo rol";
                        include '../templates/header.php';

                        if (isset($_POST['create'])) {
                            $rol = $_POST['rol'];
                            $descripcion = $_POST['descripcion'];
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "INSERT INTO roles (nombre_rol, descripcion_rol) VALUES ('$rol', '$descripcion')";
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
                                    <label for='rol' class="w3-text-theme-dark w3-medium">Rol</label>
                                    <input class='w3-input w3-border w3-round-large' name='rol' id='rol' type='text' placeholder='nombre' pattern=[A-Z\sa-z]{3,20} required>
                                    <small id="info_rol"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion" class="w3-text-theme-dark w3-medium">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light w3-round-large" name="descripcion" id="descripcion" rows="5" placeholder="(Opcional)"></textarea>
                                    <small id="info_descripcion"></small>
                                </div>

                            </div>

                            <?php
                                include '../templates/nav_btn_upd.php';
                            ?>
                        </form>
                    </div>
                    <script>
                        captarCheckbox();   
                    </script>
                    <?php
                        include '../templates/footer.php';
                    ?>