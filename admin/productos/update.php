<?php
$titulo = "Editar producto";
include '../templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fas fa-edit"></i> <?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        require '../../config/functions.php';
        $productos = getProductosById($_GET['id']);
        require "../../config/conexion.php";

        if (isset($_POST['actualizar'])) {

            $id = $productos['id'];
            $nombre = $_POST['nombre'];
            $categoria = $_POST['categoria'];
            $variedad = $_POST['variedad'];
            $pvc = $_POST['pvc'];
            $pvp = $_POST['pvp'];
            $cantidad = $_POST['cantidad'];
            $disp = $_POST['disp'];

            $sql = "UPDATE productos SET nombre ='" . $nombre . "', categoria='" . $categoria . "', variedad='" . $variedad . "', pvc='" . $pvc . "', pvp='" . $pvp . "', cantidad='" . $cantidad . "', disp='" . $disp . "' WHERE id=" . $id . ";";
            echo $sql;

            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id'])) {
                $sql = "SELECT min(id) FROM productos";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['min(id)'];
            } else {
                $id = $_POST["id"];
            }
            $sql = "SELECT id, nombre, categoria, variedad, pvc, pvp, cantidad, disp FROM productos WHERE id='$id'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            $nombre = $row['nombre'];
            $categoria = $row['categoria'];
            $variedad = $row['variedad'];
            $pvc = $row['pvc'];
            $pvp = $row['pvp'];
            $cantidad = $row['cantidad'];
            $disp = $row['disp'];
        }
        $sql = "SELECT id, nombre, categoria, variedad, pvc, pvp, cantidad, disp FROM productos";
        $result = mysqli_query($conex, $sql);

        ?>
    </div>
    <hr>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-padding-large">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="altaSocio" id="altaSocio">

                <!-- FICHA PRODUCTO  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 1: TIPO DE VENTA -->
                    <div class="w3-container">
                        <h1># <?php echo $id ?></h1>
                    </div>
                    <div class="w3-row w3-section">
                        <div class="w3-col m12 l12 w3-padding">
                            <label for="disp" class="w3-text-theme">Tipo de venta:</label>
                            <select name="disp" id="disp">
                                <option value=<?php echo $disp ?>><?php echo $disp ?></option>
                                <option value="Unidades">Unidades</option>
                                <option value="Granel">Granel</option>
                            </select>
                        </div>
                    </div>

                    <!-- FILA 2: NOMBRE Y CATEGORIA -->
                    <div class="w3-row">
                        <!-- NOMBRE -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="nombre" class="w3-text-theme">Nombre</label><br>
                            <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value=<?php echo $nombre ?>>
                            <small id="info_nombre"></small>
                        </div>
                        <!-- CATEGORIA -->
                        <div class="w3-col m6 l6 s12 w3-padding">
                            <label for="categoria">Categoría</label>
                            <select name="categoria" class="w3-select w3-white">
                                <option value=<?php echo $categoria ?>><?php echo $categoria ?></option>
                                <?php
                                require_once '../../config/functions.php';
                                $categorias = getCategorias();
                                foreach ($categorias as $categoria) :
                                ?>
                                    <option value="<?php echo $categoria['nombre'] ?>"><?php echo $categoria['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_categoria"></small>
                        </div>
                    </div>

                    <!-- FILA 3: VARIEDAD, PVC y PVP -->
                    <div class="w3-row">

                        <!-- VARIEDAD -->
                        <div class="w3-col m4 l4 s12 w3-padding nativeDatePicker">
                            <label for="variedad">Variedad</label>
                            <select name="variedad" class="w3-select w3-white">
                                <option value=<?php echo $variedad ?>><?php echo $variedad ?></option>
                                <?php
                                require_once '../../config/functions.php';
                                $variedades = getVariedades();
                                foreach ($variedades as $variedad) :
                                ?>
                                    <option value=<?php echo $variedad['nombre'] ?>><?php echo $variedad['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="info_variedad"></small>
                        </div>

                        <!-- PVC -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pvc" class="w3-text-theme">Precio de compra</label>
                            <input class="w3-input w3-border w3-round" name="pvc" id="pvc" type="text" value=<?php echo $pvc; ?>>
                            <small id="info_pvc"></small>
                        </div>

                        <!-- PVP -->
                        <div class="w3-col l4 m4 s12 w3-padding">
                            <label for="pvp" class="w3-text-theme">Precio de venta</label>
                            <input class="w3-input w3-border w3-round" name="pvp" id="pvp" type="text" value=<?php echo $pvp; ?>>
                            <small id="info_pvp"></small>
                        </div>
                    </div>
                    <!-- FILA 4 -->
                    <div class="w3-row">

                        <!-- CANTIDAD -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                            <label for="cantidad" class="w3-text-theme">Cantidad</label>
                            <input class="w3-input w3-border w3-round" name="cantidad" id="cantidad" type="text" value=<?php echo $cantidad; ?>>
                            <small id="info_cantidad"></small>
                        </div>

                        <!--  -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                        </div>

                        <!--  -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                        </div>

                        <!--  -->
                        <div class="w3-col m3 l3 s12 w3-padding">
                        </div>
                    </div>

                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-theme w3-round">
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