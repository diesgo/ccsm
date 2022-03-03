<?php
$titulo = "NUEVA CATEGORIA";
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
            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO categorias (nombre_categoria, descripcion_categoria, icono_id)
    VALUES ('$nombre_categoria', '$descripcion_categoria', '$icono_id')";

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

<div class="w3-padding-large" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="#" method="post" name="altaCategoria" id="altaCategoria">
                <!-- FICHA CATEGORIA  -->
                <div class="w3-content w3-padding">
                    <!-- FILA 1: CATEGORIA -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for='nombre_categoria'>Categoria</label>
                            <input class='w3-input w3-border w3-round' name='nombre_categoria' id='nombre_categoria' type='text' placeholder='nombre'>
                        </div>
                        <!-- DESCRIPCION -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for="descripcion_categoria">Descripción</label>
                            <input class="w3-input w3-border w3-round" name="descripcion_categoria" id="descripcion_categoria" type="text" placeholder="Descripción">
                        </div>
                        <!-- ICONO -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for="icono_id" class="w3-text-theme">Icono</label>
                            <select name="icono_id" id="icono_id" class="w3-select w3-border w3-white">
                                <?php
                                    // require_once '../../config/functions.php';
                                    $iconos = getIcono();
                                    foreach ($iconos as $icono) :
                                ?>
                                <option value=<?php echo $icono['id_icono']; ?>> <?php echo $icono['icono'] . ' ' . $icono['nombre_icono']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
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