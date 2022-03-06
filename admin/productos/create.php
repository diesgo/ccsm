<?php
$titulo = "Nuevo producto";
include '../templates/header.php';
require_once '../../config/functions.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fa fa-dashboard"></i><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        if (isset($_POST['altaButton'])) {
            
            $nombre = $_POST['nombre'];
            $categoria = $_POST['categoria'];
            $variedad = $_POST['variedad'];
            $servicio = $_POST['servicio_id'];
            $visible= $_POST['visible'];

            // Create connection

            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

            // Check connection

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO productos (nombre_producto, categoria_id, variedad_id, servicio_id, visible)
    VALUES ('$nombre', '$categoria', '$variedad',   '$servicio', '$visible')";

            if ($conn->query($sql) === TRUE) {
                echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
        ?>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="#" method="post" name="altaProducto" id="altaProducto">
                <!-- FICHA PRODUCTO  -->
                <div class="w3-content w3-padding">
                    <!-- FILA 1: SERVICIO -->
                    <div class="w3-row w3-section">
                        <div class="w3-col m2 l2 w3-padding">
                            <label for="servicio_id">Tipo de servicio</label>
                            <select name="servicio_id" class="w3-select w3-white w3-border w3-border-theme w3-round" onchange="service();">
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
                    <!-- FILA 2: NOMBRE Y CATEGORIA => VARIEDAD -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for='nombre'>Nombre</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="nombre" id="nombre" type="text" placeholder="Nombre / Name">
                        </div>
                        <!-- CATEGORIA  -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for="categoria">Categoría</label>
                            <select name="categoria" class="w3-select w3-white w3-border w3-border-theme w3-round" onchange="variedad();">
                                <?php     
                                $categorias = getCategorias();
                                foreach ($categorias as $categoria) :
                                ?>
                                    <option value=<?php echo $categoria['id_categoria']; ?>><?php echo $categoria['nombre_categoria'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- VARIEDAD -->
                        <div id="vari" class="w3-col m4 l4 s12 w3-padding w3-hide">
                            <label for="variedad">Variedad</label>
                            <select name="variedad" class="w3-select w3-white w3-border w3-border-theme w3-round">
                                <?php
                                $variedades = getVariedades();
                                foreach ($variedades as $variedad) :
                                ?>
                                    <option value=<?php echo $variedad['id_variedad']; ?>><?php echo $variedad['nombre_variedad'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Guardar" name="altaButton" class="w3-button w3-theme w3-round">
                    <a href="index.php" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>