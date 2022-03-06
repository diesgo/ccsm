<?php
$titulo = "Crear categoria";
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
            $nombre_categoria = $_POST['nombre_categoria'];
            $descripcion_categoria = $_POST['descripcion_categoria'];
            $icono_id = $_POST['icono_id'];
            $activo = $_POST['activo'];
            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO categorias (nombre_categoria, descripcion_categoria, icono_id, activo)  VALUES ('$nombre_categoria', '$descripcion_categoria', '$icono_id', '$activo')";
            if ($conn->query($sql) === TRUE) {
                echo "Se ha creado un nuevo registro";
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
            
            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="#" method="post" name="altaCategoria" id="altaCategoria">

                            <!-- FICHA CATEGORIA  -->

                            <div class="w3-content w3-padding">

                                <div class="w3-row">

                                    <!--  NOMBRE -->

                                    <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                        <label for='nombre_categoria' class="w3-text-theme w3-medium">Categoria</label>
                                        <input class='w3-input w3-border w3-round' name='nombre_categoria' id='nombre_categoria' type='text' placeholder='nombre'>
                                        <small id="info_nombre_categoria"></small>
                                    </div>

                                    <!-- ICONO -->
                                    
                                    <div class="w3-col m6 l6 s12 w3-padding">
                                        <label for="icono_id" class="w3-text-theme">Icono</label>
                                        <select name="icono_id" id="icono_id" class="w3-select w3-border w3-white">
                                            <?php
                                            $iconos = getIcono();
                                            foreach ($iconos as $icono) :
                                            ?>
                                            <option value=<?php echo $icono['id_icono']; ?>> <?php echo $icono['icono'] . ' ' . $icono['nombre_icono']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                </div>
                                
                                <!-- DESCRIPCION -->
                                
                                <div class="w3-row">
                                    <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                        <legend for="descripcion_categoria" class="w3-text-theme w3-medium">Descripción</legend>
                                        <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_categoria" id="descripcion_categoria" rows="5" placeholder="(Opcional)"></textarea>
                                        <small id="info_descripcion_categoria"></small>
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