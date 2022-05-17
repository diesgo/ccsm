            <?php
                $titulo="Actualizar producto";
                include '../templates/header.php';
                require '../../config/conexion.php';
                $producto = getProductsById($_GET['id']);
                if (isset($_POST['update'])) {
                    $id = $producto['id_producto'];
                    $nombre = $_POST['nombre'];
                    $servicio = $_POST['servicio'];
                    $categoria = $_POST['categoria'];
                    $variedad = $_POST['variedad'];
                    $bote = $_POST['bote'];
                    $pvp = $_POST['pvp'];
                    $dispensario = $_POST['dispensario'];
                    $activo = isset($_POST['activo']) ? "1" : "0";
                    $sql = "UPDATE productos SET
                    nombre_producto = '" . $nombre . "',
                    activo = '" . $activo ."',
                    servicio_id = '" . $servicio ."',
                    categoria_id = '" . $categoria ."',
                    variedad_id = '" . $variedad ."',
                    bote = '" . $bote . "',
                    pvp = '" . $pvp ."',
                    dispensario = '" . $dispensario ."'
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

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b>Editar <?php echo $producto['nombre_producto'] ?></b></h2>
                </div>
            </div>


            <div class="w3-container w3-padding w3-responsive">

                            <div class="w3-row w3-margin-bottom">
                                <div class="w3-col l1 m1">
                                    <div class="w3-container"></div>
                                </div>
                                <div class="w3-col l2 m2 w3-center">
                                    <h4 class="w3-text-theme">Nombre: <span class="w3-text-dark-grey"><?php echo $producto['nombre_producto']; ?></span></h4>
                                </div>
                                <div class="w3-col l2 m2 w3-center">
                                    <h4 class="w3-text-theme">Categoría: <span class="w3-text-dark-grey"><?php echo $producto['nombre_categoria']; ?></span></h4>
                                </div>
                                <div class="w3-col l2 m2 w3-center">
                                    <h4 class="w3-text-theme">Variedad: <span class="w3-text-dark-grey"><?php echo $producto['nombre_variedad']; ?></span></h4>                            
                                </div>
                                <div class="w3-col l2 m2 w3-center">
                                    <h4 class="w3-text-theme">Stock actual: <span class="w3-text-dark-grey"><?php echo $producto['cantidad']; ?> gr.</span></h4>
                                </div>
                                <div class="w3-col l2 m2 w3-center">
                                    <h4 class="w3-text-theme">Precio de venta: <span class="w3-text-dark-grey"><?php echo $producto['pvp']; ?> €</span></h4>
                                </div>
                                <div class="w3-col l1 m1 w3-center">
                                    <div class="w3-container"></div>
                                </div>
                            </div>

                        <div class="w3-container">
                            <div style="width: 40%; margin: 0 auto;" class="w3-mobile">
                                <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                                    <div class="w3-row w3-padding">

                                        <div class="w3-col l6 m6 w3-padding">
                                            <label for='nombre' class="w3-text-theme-dark w3-medium">Nombre</label>
                                            <input class="w3-input w3-border w3-round-large" name="nombre" id="nombre" type="text" placeholder="Nombre / Name" value="<?php echo $producto['nombre_producto']?>" pattern=[A-Z\sa-z]{3,20} required>
                                        </div>

                                        <div class="w3-col l6 m6 w3-padding">
                                            <label for="servicio" class="w3-text-theme-dark w3-medium">Tipo de servicio</label>
                                            <select name="servicio" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round-large" onchange="service();" require>
                                                <option value=<?php echo $producto['servicio_id']; ?>><?php echo $producto['servicio_id'] ?></option>
                                                <?php
                                                    $servicios = getServicios();
                                                    foreach ($servicios as $servicio) :
                                                ?>
                                                <option value=<?php echo $servicio['id_servicio']; ?>><?php echo $servicio['nombre_servicio'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w3-row w3-padding">

                                        <div class="w3-col l6 m6 w3-padding">
                                            <label for="categoria" class="w3-text-theme-dark w3-medium">Categoría</label>
                                            <select name="categoria" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round-large" require>
                                                <option value=<?php echo $producto['categoria_id']; ?>><?php echo $producto['categoria_id'] ?></option>
                                                <?php
                                                    $categorias = getCategorias();
                                                    foreach ($categorias as $categoria) :
                                                ?>
                                                <option value=<?php echo $categoria['id_categoria']; ?>><?php echo $categoria['nombre_categoria'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div id="vari" class="w3-col l6 m6 w3-padding w3-hide">
                                            <label for="variedad" class="w3-text-theme-dark w3-medium">Variedad</label>
                                            <select name="variedad" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round-large">
                                                <option value=<?php echo $producto['variedad_id']; ?>><?php echo $producto['variedad_id']; ?></option>
                                                <?php
                                                    $variedades = getVariedades();
                                                    foreach ($variedades as $variedad) :
                                                ?>
                                                <option value=<?php echo $variedad['id_variedad']; ?>><?php echo $variedad['nombre_variedad'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w3-row w3-padding">

                                        <div class="w3-col l6 m6 w3-padding">
                                            <label for='bote' class="w3-text-theme-dark w3-medium">Peso bote</label>
                                            <input class="w3-input w3-border w3-round-large" name="bote" id="bote" type="text" placeholder="gr" value="<?php echo $producto['bote']; ?>" required>
                                        </div>

                                        <div class="w3-col l6 m6 w3-padding">
                                            <label for='pvp' class="w3-text-theme-dark w3-medium">PVP</label>
                                            <input class="w3-input w3-border w3-round-large" name="pvp" id="pvp" type="text" placeholder="€" value="<?php echo $producto['pvp']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="w3-row w3-padding">

                                        <div class="w3-col l6 m6 w3-padding">
                                            <label for='stock' class="w3-text-theme-dark w3-medium">Stock</label>
                                            <input class="w3-input w3-border w3-round-large" name="stock" id="stock" type="text" placeholder="gr" value="<?php echo $producto['cantidad']; ?>" required>
                                        </div>

                                        <div class="w3-col l6 m6 w3-padding">
                                            <label for='dispensario' class="w3-text-theme-dark w3-medium">Dispensario</label>
                                            <input class="w3-input w3-border w3-round-large" name="dispensario" id="dispensario" type="text" placeholder="gr." value="<?php echo $producto['dispensario']; ?>" required>
                                        </div>

                                    </div>

                                    <div class="w3-row w3-padding">
                                        <div class="w3-col w3-padding">
                                            <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                            <!-- <label class="switch"> -->
                                                <input id="activo" class="activo" type="checkbox"  name="activo" value="<?php echo $producto['activo'] ?>">
                                                <!-- <span class="slider round"></span> -->
                                            </label>
                                        </div>

                                        <script>
                                            service();
                                            check = document.getElementById('activo');
                                            console.log(check.value);
                                        </script>

                                    </div>

                                     <?php
                                        include '../templates/nav_btn_upd.php';
                                    ?>
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