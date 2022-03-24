                <?php
                    $titulo = "Editar producto";
                    include '../templates/header.php';
                    require '../../config/conexion.php';
                    $producto = getProductosById($_GET['id']);
                    if (isset($_POST['update'])) {
                        $id = $producto['id_producto'];
                        $nombre = $_POST['nombre'];
                        $servicio = $_POST['servicio'];
                        $categoria = $_POST['categoria'];
                        $variedad = $_POST['variedad'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        $sql = "UPDATE productos SET
                        nombre_producto = '" . $nombre . "',
                        activo = '" . $activo ."',
                        servicio_id = '" . $servicio ."',
                        categoria_id = '" . $categoria ."',
                        variedad_id = '" . $variedad ."'
                        WHERE id_producto = " . $id . ";";
                        echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                        echo "<script>location.replace('index.php');</script>";
                        mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                    } else {
                        if (!isset($_POST['id_producto'])) {
                            $sql = "SELECT min(id_producto) FROM productos";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['min(id_producto)'];
                        } else {
                            $id = $_POST["id_producto"];
                        }
                        $sql = "SELECT * FROM productos WHERE id_producto = '$id'";
                        $result = mysqli_query($conex, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $nombre = $row['nombre_producto'];
                        $activo = $row['activo'];
                    }
                    $sql = "SELECT * FROM productos";
                    $result = mysqli_query($conex, $sql);
                ?>
            <div class="w3-container w3-padding-32 w3-center w3-theme-l4">
                <h2 class="w3-text-theme"><b><?php echo $producto['nombre_producto']; ?></b></h2>
            </div>

            <div class="w3-container w3-padding-16 w3-responsive" style="min-height: 594px;">
                <div class="w3-content">
                    <div class="w3-row-padding">
                        <div class="w3-col l3 m3">
                            <h4 class="w3-text-theme">Categoría: <span class="w3-text-dark-grey"><?php echo $producto['categoria_id']; ?></span></h4>                            
                        </div>
                        <div class="w3-col l3 m3">
                            <h4 class="w3-text-theme">Variedad: <span class="w3-text-dark-grey"><?php echo $producto['variedad_id']; ?></span></h4>                            
                        </div>
                        <div class="w3-col l3 m3">
                            <h4 class="w3-text-theme">Stock actual: <span class="w3-text-dark-grey"><?php echo $producto['cantidad']; ?> gr.</span></h4>
                        </div>
                        <div class="w3-col l3 m3">
                            <h4 class="w3-text-theme">Precio de venta: <span class="w3-text-dark-grey"><?php echo $producto['pvp']; ?> €</span></h4>
                        </div>
                    </div>

                    <!-- FORMULARIO -->

                    <div class="w3-container w3-padding w3-theme-l4 w3-margin-top w3-round w3-mobile" style="width: 35%; margin: 0 auto">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for='nombre' class="w3-text-theme w3-medium">Nombre</label>
                                    <input class="w3-input w3-border w3-border-theme-l4 w3-round" name="nombre" id="nombre" type="text" placeholder="Nombre / Name" value="<?php echo $producto['nombre_producto']?>" onkeyup="checkName('nombre')" require>
                                </div>

                                <div class="w3-col w3-padding">
                                     <label for="servicio" class="w3-text-theme w3-medium">Tipo de servicio</label>
                                    <select name="servicio" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round" onchange="service();" require>
                                        <option value=<?php echo $producto['servicio_id']; ?>><?php echo $producto['servicio_id'] ?></option>
                                        <?php
                                            $servicios = getServicios();
                                            foreach ($servicios as $servicio) :
                                        ?>
                                        <option value=<?php echo $servicio['id_servicio']; ?>><?php echo $servicio['nombre_servicio'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="w3-col w3-padding">
                                    <label for="categoria" class="w3-text-theme w3-medium">Categoría</label>
                                    <select name="categoria" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round" require>
                                        <option value=<?php echo $producto['categoria_id']; ?>><?php echo $producto['categoria_id'] ?></option>
                                        <?php
                                            $categorias = getCategorias();
                                            foreach ($categorias as $categoria) :
                                        ?>
                                        <option value=<?php echo $categoria['id_categoria']; ?>><?php echo $categoria['nombre_categoria'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div id="vari" class="w3-col w3-padding w3-hide">
                                    <label for="variedad" class="w3-text-theme w3-medium">Variedad</label>
                                    <select name="variedad" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round">
                                        <option value=<?php echo $producto['variedad_id']; ?>><?php echo $producto['variedad_id']; ?></option>
                                        <?php
                                            $variedades = getVariedades();
                                            foreach ($variedades as $variedad) :
                                        ?>
                                        <option value=<?php echo $variedad['id_variedad']; ?>><?php echo $variedad['nombre_variedad'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $producto['activo'] ?>">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <script>service();</script>

                            </div>

                            <!-- BOTONES DE NAVEGACIÓN -->

                            <div class="w3-row w3-center">
                                <div class="w3-col l6 m6 s6 w3-padding">
                                    <a href="index.php" class="w3-btn w3-theme w3-round w3-hover-green">Volver</a>
                                </div>    
                                <div class="w3-col l6 m6 s6 w3-padding">
                                    <input type="submit" value="Guardar" name="update" class="w3-btn w3-theme w3-round w3-hover-orange">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <script>
                captarCheckbox();
            </script>
            <?php
                include '../templates/footer.php';
            ?>