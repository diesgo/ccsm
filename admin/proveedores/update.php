<?php
$titulo = "EDITAR PRODUCTO";
include '../templates/header.php';
$productos = getProductosById($_GET['id']);
?>

<!-- HEADER -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?> id: <?php echo $productos['id_producto'] ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        // require '../../config/conexion.php';
        if (isset($_POST['actualizar'])) {
            $id = $productos['id_producto'];
            $nombre = $productos['nombre_producto'];
            $categoria = $_POST['categoria'];
            $variedad = $_POST['variedad'];
            $cantidad = $_POST['cantidad'] + $productos['cantidad'];
            $pvc = $_POST['pvc'];
            $pvp = $_POST['pvp'];
            $sql = "UPDATE productos SET nombre_producto = '" . $nombre . "',
            categoria_id = '" . $categoria . "',
            variedad_id = '" . $variedad . "',
            cantidad = '" . $cantidad . "',
            pvc = '" . $pvc . "',
            pvp = '" . $pvp . "'
            WHERE id_producto = " . $id . ";";
            echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Cambios guardados</h3>";
            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id'])) {
                $sql = "SELECT min(id_producto) FROM productos";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id_producto)'];
            } else {
                $id = $_POST["id"];
            }
            $sql = "SELECT * FROM productos WHERE id_producto = '$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id_producto'];
            $nombre = $row['nombre_producto'];
            $categoria = $row['categoria_id'];
            $variedad = $row['variedad_id'];
            $cantidad = $row['cantidad'];
            $pvc = $row['pvc'];
            $pvp = $row['pvp'];
        }
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conex, $sql);
        ?>
    </div>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div class="w3-row">
        <h2 style="text-transform: uppercase;" class="w3-center w3-text-theme"><?php echo $productos['nombre_producto'] ?></h2>
        <!-- <h4 class="w3-center w3-text-theme">Tipo de servicio: <span style="text-transform: capitalize;"><?php echo $productos['servicio'] ?></span></h4> -->
    </div>
    <div class="w3-container w3-border w3-border-theme">
        <div class="w3-bar">
            <button class="w3-bar-item w3-button tablink w3-theme-l4" onclick="changeTab(event,'resumen')">Resumen</button>
            <button class="w3-bar-item w3-button tablink" onclick="changeTab(event,'compra')">Compra</button>
            <button class="w3-bar-item w3-button tablink" onclick="changeTab(event,'venta')">Venta</button>
            <button class="w3-bar-item w3-button tablink" onclick="changeTab(event,'ajustes')">Ajustes</button>
        </div>
        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="actualizarProductos" id="actualizarProductos">

            <div id="resumen" class="w3-container w3-border w3-theme-l4 w3-border-theme-l4 ficha">
                <div class="w3-row-padding">

                    <!-- PVC -->

                    <div class="w3-col l3 m3 w3-padding">
                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                            <legend>PVC:</legend>
                            <p id="pvcAhora" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom"><?php echo $productos['pvc'] ?></p>
                        </div>
                    </div>

                    <!--CANTIDAD -->

                    <div class="w3-col l3 m3 w3-padding">
                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                            <legend class="w3-text-theme">Stock actual</legend>
                            <p id="cantidadAhora" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom"><?php echo $productos['cantidad'] ?></p>
                        </div>
                    </div>

                    <script>
                        function cargar() {
                            var stock = $productos['cantidad'];
                            var add = $_POST['cantidad'];
                            var cantidad = $stock + $add;
                            console.log(stock);
                        }
                    </script>

                </div>
            </div>

            <div id="compra" class="w3-container w3-border w3-theme-l4 w3-border-theme-l4 ficha" style="display:none">
                <div class="w3-row-padding">

                    <!-- PVC -->

                    <div class="w3-col l3 m3 w3-padding">
                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                            <label for="pvc" class="w3-text-theme">PVC</label>
                            <input id="pvc" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" name="pvc" value="0" placeholder="0.00">
                        </div>
                    </div>

                    <!--CANTIDAD -->

                    <div class="w3-col l3 m3 w3-padding">
                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                            <label for="cantidad" class="w3-text-theme">Cantidad</label>
                            <input id="cantidad" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" name="cantidad" value="0" onkeyup="cargar();">
                        </div>
                    </div>

                    <script>
                        function cargar() {
                            var stock = $productos['cantidad'];
                            var add = $_POST['cantidad'];
                            var cantidad = $stock + $add;
                            console.log(stock);
                        }
                    </script>

                </div>
            </div>

            <div id="venta" class="w3-container w3-border w3-theme-l4 w3-border-theme-l4 ficha" style="display:none">
                <div class="w3-row-padding">

                    <!-- PVP -->

                    <div class="w3-col l3 m3 w3-padding">
                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                            <label for="pvp" class="w3-text-theme">PVP</label>
                            <input id="pvp" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" name="pvp" value=<?php echo $productos['pvp'] ?>>
                        </div>
                    </div>

                </div>
            </div>

            <div id="ajustes" class="w3-container w3-border w3-theme-l4 w3-border-theme-l4 ficha" style="display:none">
                <div class="w3-row-padding">

                    <!-- SERVICIO -->

                    <div class="w3-col m3 l3 w3-padding">
                        <div class="w3-container w3-padding-16 w3-border w3-border-theme w3-round">
                            <label for="servicio" class="w3-text-theme">Tipo de servicio</label>
                            <select name="servicio" class="w3-select w3-white w3-border w3-border-theme w3-round" onchange="service();">
                                <!-- <option value="<?php echo $productos['servicio'] ?>"><?php echo $productos['servicio'] ?></option> -->
                                <option value="granel">Granel</option>
                                <option value="unidad">Unidad</option>
                            </select>
                        </div>
                    </div>

                    <!-- BOTE -->

                    <div id="tara" class="w3-col l3 m3 w3-padding w3-hide">
                        <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                            <label for="bote" class="w3-text-theme">Peso del bote</label>
                            <!-- <input id="bote" class="w3-input w3-border w3-border-theme w3-round w3-margin-bottom" type="text" name="bote" value=<?php echo $productos['bote'] ?>> -->
                        </div>
                    </div>

                    <!-- CATEGORIA  -->

                    <div class="w3-col m3 l3 w3-padding">
                        <div class="w3-container w3-padding-16 w3-border w3-border-theme w3-round">
                            <label for="categoria" class="w3-text-theme">Categoría</label>
                            <select name="categoria" class="w3-select w3-white w3-border w3-border-theme w3-round" onchange="service();">
                                <option value="<?php echo $productos['categoria_id'] ?>"><?php echo $productos['nombre_categoria'] ?></option>
                                <?php
                                require_once '../../config/functions.php';
                                $categorias = getCategorias();
                                foreach ($categorias as $categoria) :
                                ?>
                                    <option value=<?php echo $categoria['id_categoria']; ?>><?php echo $categoria['icono'] . ' ' . $categoria['nombre_categoria'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- VARIEDAD -->

                    <div id="variedad" class="w3-col m3 l3 w3-padding">
                        <div class="w3-container w3-padding-16 w3-border w3-border-theme w3-round">
                            <label for="variedad" class="w3-text-theme">Variedad</label>
                            <select name="variedad" class="w3-select w3-white w3-border w3-border-theme w3-round">
                                <option value="<?php echo $productos['variedad_id'] ?>"><?php echo $productos['nombre_variedad'] ?></option>
                                <?php
                                // require_once '../../config/functions.php';
                                $variedades = getVariedades();
                                foreach ($variedades as $variedad) :
                                ?>
                                    <option value=<?php echo $variedad['id_variedad']; ?>><?php echo $variedad['nombre_variedad'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w3-container">
                <div class="w3-container w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">
                    <a href="index.php" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">Volver</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function changeTab(evt, tabName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("ficha");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-theme-l4", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " w3-theme-l4";
    }

    function service() {
        var text;
        var servicio = actualizarProductos.servicio.value;
        var categoria = actualizarProductos.categoria.value;
        var variedad;
        var tara = document.getElementById('tara');
        switch (servicio) {
            case "granel":
                tara.classList.remove('w3-hide');
                break;
            case "Granel":
                tara.classList.remove('w3-hide');

                break;
            case "unidad":
                break;
            default:
                text = "I have never heard of that fruit...";
        };
        if (categoria === "hash" || categoria === "weed") {
            document.getElementById('variedad').classList.remove('w3-hide');
        } else {
            actualizarProductos.variedad.value = "";
        }
    }
    service();
</script>

<?php
include '../templates/footer.php';
?>