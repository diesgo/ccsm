<?php
$titulo = "Nuevo artículo";
include '../templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fa fa-dashboard"></i><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        if (isset($_POST['altaButton'])) {
            require_once '../../config/config.php';

            $nombre = $_POST['nombre'];
            $categoria = $_POST['categoria'];
            $variedad = $_POST['variedad'];
            $bote = $_POST['bote'];
            $pvc = $_POST['pvc'];
            $pvp = $_POST['pvp'];
            $cantidad = $_POST['cantidad'];
            $disp = $_POST['disp'];

            // Create connection

            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

            // Check connection

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO productos (nombre, categoria, variedad, bote, pvc, pvp, cantidad, disp)
    VALUES ('$nombre', '$categoria', '$variedad', '$bote', '$pvc', '$pvp', '$cantidad', '$disp')";

            if ($conn->query($sql) === TRUE) {
                echo "Se ha creado un nuevo registro";
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
                    <!-- FILA 1: DISP -->
                    <div class="w3-row w3-section">
                        <div class="w3-col m2 l2 w3-padding">
                            <label for="disp">Tipo de servicio</label>
                            <select name="disp" class="w3-select w3-white w3-border w3-border-theme w3-round" onchange="servicio();">
                                <option value="">Seleccionar...</option>
                                <option value="granel">Granel</option>
                                <option value="unidad">Unidad</option>
                            </select>
                        </div>
                        <!-- BOTE -->
                        <div id="setCup" class="w3-col m2 l2 w3-padding w3-hide">
                            <label for="disp">Peso del bote</label>
                            <input type="text" name="bote" id="bote" class="w3-input w3-border w3-border-theme w3-round">
                        </div>
                        <script>
                            function servicio() {
                                var text;
                                var serv = altaProducto.disp.value;
                                var cup = document.getElementById("setCup");
                                switch (serv) {
                                    case "":
                                        cup.classList.add('w3-hide');
                                        vari.classList.add('w3-hide');
                                        break;
                                    case "granel":
                                        cup.classList.remove('w3-hide');
                                        vari.classList.remove('w3-hide');
                                        break;
                                    case "unidad":
                                        cup.classList.add('w3-hide');
                                        vari.classList.add('w3-hide');
                                        break;
                                    default:
                                        text = "I have never heard of that fruit...";
                                };
                            }
                        </script>
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
                            <select name="categoria" class="w3-select w3-white w3-border w3-border-theme w3-round">
                                <option value="">Seleccionar...</option>
                                <?php
                                require_once '../../config/functions.php';
                                $categorias = getCategorias();
                                foreach ($categorias as $categoria) :
                                ?>
                                    <option value=<?php echo $categoria['nombre']; ?>><?php echo $categoria['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- VARIEDAD -->
                        <div id="vari" class="w3-col m4 l4 s12 w3-padding w3-hide">
                            <label for="variedad">Variedad</label>
                            <select name="variedad" class="w3-select w3-white w3-border w3-border-theme w3-round">
                                <option value="">Seleccionar...</option>
                                <?php
                                require_once '../../config/functions.php';
                                $variedades = getVariedades();
                                foreach ($variedades as $variedad) :
                                ?>
                                    <option value=<?php echo $variedad['nombre']; ?>><?php echo $variedad['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- FILA 3:  PVC Y PVP -->
                    <div class="w3-row">

                        <!-- PVC -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pvc">Precio de compra</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="pvc" id="pvc" type="text" value="0.00">
                            <small id="info_pvc"></small>
                        </div>
                        <!-- PVP -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pvp">Precio de venta</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="pvp" id="pvp" type="text" value="0.00">
                            <small id="info_pvc"></small>
                        </div>
                        <!-- CANTIDAD -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for="cantidad">Cantidad</label>
                            <input class="w3-input w3-border w3-border-theme w3-round" name="cantidad" id="cantitad" type="text" value="0.00">
                            <small id="info_cantidad"></small>
                        </div>
                    </div>
                    <!-- FILA 4: CANTIDAD -->
                    <div class="w3-row">

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