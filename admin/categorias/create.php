                    <?php
                        $titulo = "Crear categoria";
                        include '../templates/header.php';
                        if (isset($_POST['addnew'])) {
                            $nombre_categoria = $_POST['nombre'];
                            $descripcion_categoria = $_POST['descripcion'];
                            $activo = isset($_POST['activo']) ? "1" : "0";
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "INSERT INTO categorias (nombre_categoria, descripcion_categoria, activo)  VALUES ('$nombre_categoria', '$descripcion_categoria', '$activo')";
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
                                    <label for='nombrea' class="w3-text-theme-dark w3-medium">Categoria</label>
                                    <input class='w3-input w3-border w3-round-large' name='nombre' id='nombre' type='text' placeholder='nombre' pattern=[A-Z\sa-z]{3,20} required>
                                    <small id="info_nombre"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion" class="w3-text-theme-dark w3-medium">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light w3-round-large" name="descripcion" id="descripcion" rows="5" placeholder="(Opcional)"></textarea>
                                    <small id="info_descripcion"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <?php
                                    include '../templates/nav_btn_add.php';
                                ?>
                            </div>
                        </form>
                    </div>
                    <?php
                        include '../templates/footer.php';
                    ?>