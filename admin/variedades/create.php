<?php
$titulo = "NUEVA VARIEDAD";
include '../templates/header.php';
?>



            <!-- Header -->

            <div class="w3-container w3-padding-32 w3-theme-l4">
                <div class="w3-half">
                    <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
                <div class="w3-half">
                    <?php
                    if (isset($_POST['altaButton'])) {
                        $nombre_variedad = $_POST['nombre_variedad'];
                        $descripcion_variedad = $_POST['descripcion_variedad'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        // Create connection
                        $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                        // Check connection
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
                </div>
            </div>

            <!-- !PAGE CONTENT! -->
            
            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 594px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="#" method="post" name="altaVariedad" id="altaVariedad">

                            <!-- FICHA VARIEDAD  -->

                            <div class="w3-content w3-padding">
                                
                                <!--  NOMBRE -->

                                <div class="w3-row">
                                    <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                        <label for='nombre_variedad' class="w3-text-theme w3-medium">Variedad</label>
                                        <input class='w3-input w3-border w3-round' name='nombre_variedad' id='nombre_variedad' type='text' placeholder='nombre'>
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
                                    <div class="w3-col m5 l6 s12 w3-padding w3-margin-top">
                                        <input class="w3-check" type="checkbox" id="activo" name="activo">
                                        <label for="activo" class="w3-text-theme w3-medium">Activo</label>
                                    </div>
                                </div>
                            </div>

                            <!-- BOTONES NAVEGACIÓN -->
                            
                            <div class="w3-row w3-padding-32 w3-center">
                                <input type="submit" value="Guardar" name="altaButton" class="w3-button w3-theme w3-round">
                                <a href="index.php" class="w3-button w3-theme w3-round">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- !End page content! -->
            
            <?php
            include '../templates/footer.php';
            ?>