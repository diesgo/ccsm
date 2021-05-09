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
            $variedad = $_POST['nombre'];
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
            $sql = "INSERT INTO productos (nombre, categoria, variedad, pvc, pvp, cantidad, disp)
    VALUES ('$nombre', '$categoria', '$variedad', '$pvc', '$pvp', '$cantidad', '$disp')";

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

<div class="w3-padding-large" style="min-height: 570px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="#" method="post" name="altaSocio" id="altaSocio">
                <!-- FICHA PRODUCTO  -->
                <div class="w3-content w3-padding">
                    <!-- FILA 1: DISP -->
                    <div class="w3-row w3-section">
                        <div class="w3-col m12 l12 w3-padding">
                            <legend>Tipo de servicio:</legend>
                            <input class="w3-radio" type="radio" name="disp" value="unidades" checked>
                            <label>Unidades</label>
                            <input class="w3-radio" type="radio" name="disp" value="granel">
                            <label>Granel</label>
                        </div>
                    </div>
                    <!-- FILA 2: NOMBRE Y CATEGORIA -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for='nombre'>Nombre</label>
                            <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' placeholder='Nombre / Name'>
                            <small id="info_nombre"></small>
                        </div>
                        <!-- CATEGORIA  -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="categoria">Categoría</label>
                            <select name="categoria" class="w3-select w3-white">
                                <option value="">Seleccionar...</option>
                                <?php
                                require_once '../../config/functions.php';
                                $categorias = getCategorias();
                                foreach ($categorias as $categoria) :
                                ?>
                                    <option value=<?php echo $categoria['nombre']; ?>><?php echo $categoria['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_categoria"></small>
                        </div>
                    </div>
                    <!-- FILA 3: VARIEDAD, PVC Y PVP -->
                    <div class="w3-row">
                        <!-- VARIEDAD -->
                        <div class="w3-col m4 l4 s12 w3-padding nativeDatePicker">
                            <label for="variedad">Variedad</label>
                            <select name="variedad" class="w3-select w3-white">
                                <option value="">Seleccionar...</option>
                                <?php
                                require_once '../../config/functions.php';
                                $variedades = getVariedades();
                                foreach ($variedades as $variedad) :
                                ?>
                                    <option value=<?php echo $variedad['nombre']; ?>><?php echo $variedad['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_variedad"></small>
                        </div>
                        <!-- PVC -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pvc">Precio de compra</label>
                            <input class="w3-input w3-border w3-round" name="pvc" id="pvc" type="text" value="0.00">
                            <small id="info_pvc"></small>
                        </div>
                        <!-- PVP -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pvp">Precio de venta</label>
                            <input class="w3-input w3-border w3-round" name="pvp" id="pvp" type="text" value="0.00">
                            <small id="info_pvc"></small>
                        </div>
                    </div>
                    <!-- FILA 4: CANTIDAD -->
                    <div class="w3-row">
                        <!-- CANTIDAD -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="cantidad">Cantidad</label>
                            <input class="w3-input w3-border w3-round" name="cantidad" id="cantitad" type="text" value="0.00">
                            <small id="info_cantidad"></small>
                        </div>
                        <!-- CAREGORIA  -->
                        <!-- <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="categoria" class="w3-text-theme">Esquema de color</label>
                            <select name="categoria" id="categoria" class="w3-select w3-white">
                                <option value="">Seleccionar</option>
                                <?php
                                $color = getCategorias();
                                foreach ($color as $color) :
                                ?>
                                    <option value=<?php echo $color['nombre']; ?>><?php echo $color['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_rol"></small>
                        </div> -->
                        <!-- VARIEDAD -->
                        <!-- <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="variedad" class="w3-text-theme">Fuente</label>
                            <select name="variedad" id="variedad" class="w3-select w3-white">
                                <?php
                                $fuente = getVariedades();
                                foreach ($fuente as $fuente) :
                                ?>
                                    <option value=<?php echo $fuente['nombre']; ?>><?php echo $fuente['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_rol"></small>
                        </div> -->
                        <!--  -->
                        <div class="w3-col m3 l3 s12 w3-padding">

                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Guardar" name="altaButton" class="w3-button w3-theme w3-round">
                    <!-- <input title="Guardar el producto y permanecer en la página actual: ALT+SHIFT+S" />
                    <button type="button" class="w3-button w3-theme w3-round" id="product_form_save_go_to_catalog_btn" data-toggle="pstooltip" title="Guardar y regresar al catálogo: ALT+SHIFT+Q">Ir al catálogo</button>
                    <button type="button" class="w3-button w3-theme w3-round" id="product_form_save_new_btn" data-toggle="pstooltip" title="Guardar y crear un nuevo producto: ALT+SHIFT+P">Añadir nuevo producto</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- !End page content! -->
<?php
include '../templates/footer.php';
?>