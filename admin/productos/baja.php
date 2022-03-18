                <?php
                    $titulo='Borrar producto';
                    include '../templates/headIndex.php';
                    require '../../conex.php';
                    $producto = getProductsById($_GET['id']);
                    if(isset($_POST['bajaButton'])){
                        $id_producto = $producto['id_producto'];
                        $nombre = $producto['nombre_producto'];
                        $categoria = $producto['nombre_categoria'];
                        $variedad = $producto['nombre_variedad'];
                        $cantidad = $producto['cantidad'];
                        $dispensario = $producto['dispensario'];

                          // Create connection

                        $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

                        // Check connection

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "INSERT INTO delete_products (product_id, product, category, strain, quantity, shop) VALUES ('$id_producto', '$nombre', '$categoria', '$variedad', '$cantidad', '$dispensario')";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "<h3 class='w3-text-green w3-animate-zoom'><i class='w3-xlarge fas fa-check'></i> Se ha creado un nuevo registro</h3>";
                            // echo "<script>location.replace('index.php');</script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                        
                        $sql = "DELETE FROM productos WHERE id_producto='$id_producto'";
                        mysqli_query($conex, $sql);
                        // echo "<script>location.replace('index.php');</script>";
                    }
                ?>
                <div class="w3-content">
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="borrarproducto" id="borrarproducto" class="w3-theme-l4 w3-round w3-padding">

                        <!-- NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for='nombre_producto' class="w3-text-theme w3-medium">Servicio</label>
                                <input class="w3-input w3-border w3-border-theme-light" type="text" name="nombre_producto" placeholder="<?php echo $producto['nombre_producto']; ?>" value="<?php echo $producto['nombre_producto']; ?>">
                            </div>
                        </div>

                        <!-- ACTIVO -->

                        <div class="w3-row">
                            <div class="w3-col w3-padding w3-margin-top">
                                <label class="switch">
                                    <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $producto['activo']?>">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- BOTONES DE NAVEGACIÓN -->

                        <div class="w3-row w3-padding-32 w3-center">
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <a href="index.php" class="w3-btn w3-theme w3-round w3-block w3-hover-green">Volver</a>
                            </div>
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <input type="submit" value="Eliminar" name="bajaButton" class="w3-btn w3-theme w3-round w3-block w3-hover-red">
                            </div>
                        </div>
                    </form>
                </div>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                    include '../templates/footerClean.php';
                    ?>