                <?php
                    $titulo = "Editar producto";
                    include '../templates/header.php';
                    require '../../config/conexion.php';
                    $producto = getProductsById($_GET['id']);
                    if (isset($_POST['update'])) {
                        $id = $producto['id_producto'];
                        $bote = $_POST['bote'];
                        $pvp = $_POST['pvp'];
                        $dispensario = $_POST['dispensario'];
                        $sql = "UPDATE productos SET
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
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

                <div class="w3-container w3-padding-16 w3-responsive" style="min-height: 594px;">
                    <div class="w3-content">
                        <div class="w3-row-padding">
                            <div class="w3-col l3 m3">
                                <h4 class="w3-text-theme">Categoría: <span class="w3-text-dark-grey"><?php echo $producto['nombre_categoria']; ?></span></h4>                            
                            </div>
                            <div class="w3-col l3 m3">
                                <h4 class="w3-text-theme">Variedad: <span class="w3-text-dark-grey"><?php echo $producto['nombre_variedad']; ?></span></h4>                            
                            </div>
                            <div class="w3-col l3 m3">
                                <h4 class="w3-text-theme">Stock actual: <span class="w3-text-dark-grey"><?php echo $producto['cantidad']; ?> gr.</span></h4>
                            </div>
                            <div class="w3-col l3 m3">
                                <h4 class="w3-text-theme">Precio de venta: <span class="w3-text-dark-grey"><?php echo $producto['pvp']; ?> €</span></h4>
                            </div>
                        </div>
                        
                        <!-- FORMULARIO -->
                        
                        <div class="w3-container w3-padding w3-theme-l4 w3-margin-top w3-round" style="width: 35%; margin: 0 auto">
                            <form accept-charset="utf-8" action="#" method="post" name="form" id="form">
                                <div class="w3-row">

                                    <div class="w3-col w3-padding">
                                        <label for='bote' class="w3-text-theme w3-medium">Bote</label>
                                        <input class="w3-input w3-border w3-border-theme-l4 w3-round" name="bote" id="bote" type="text" placeholder="gr" value="<?php echo $producto['bote']; ?>" required>
                                    </div>

                                    <div class="w3-col w3-padding">
                                        <label for='pvp' class="w3-text-theme w3-medium">PVP</label>
                                        <input class="w3-input w3-border w3-border-theme-l4 w3-round" name="pvp" id="pvp" type="text" placeholder="€" value="<?php echo $producto['pvp']; ?>" required>
                                    </div>

                                    <div class="w3-col w3-padding">
                                        <label for='stock' class="w3-text-theme w3-medium">Stock</label>
                                        <input class="w3-input w3-border w3-border-theme-l4 w3-round" name="stock" id="stock" type="text" placeholder="gr" value="<?php echo $producto['cantidad']; ?>" required>
                                    </div>

                                    <div class="w3-col w3-padding">
                                        <label for='dispensario' class="w3-text-theme w3-medium">Dispensario</label>
                                        <input class="w3-input w3-border w3-border-theme-l4 w3-round" name="dispensario" id="dispensario" type="text" placeholder="€" value="<?php echo $producto['dispensario']; ?>" required>
                                    </div>

                                </div>

                            <div class="w3-row w3-center">

                                <!-- BOTONES DE NAVEGACIÓN -->

                                <div class="w3-col l6 m6 s12 w3-padding-large">
                                    <a href="index.php" class="w3-btn w3-theme w3-round w3-hover-green">Volver</a>
                                </div>    
                                <div class="w3-col l6 m6 s12 w3-padding-large">
                                    <input type="submit" value="Guardar" name="update" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">
                                </div>

                            </div>
                        </form>
                        </div>

                    </div>
                </div>
                <?php
                include '../templates/footer.php';
                ?>