<?php
$titulo = "EDITAR PRODUCTO";
include '../templates/header.php';
require_once '../../config/conexion.php';
$producto = getProductosById($_GET['id']);
?>

            <!-- HEADER -->
            
            <?php

            // Create connection

            $conex=new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

            // Check connection

            if ($conex->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            if (isset($_POST['actualizar'])) {
                $id = $producto['id_producto'];
                $nombre = $_POST['nombre_producto'];
                $categoria = $_POST['categoria_id'];
                $variedad = $_POST['variedad_id'];
                $sql = "UPDATE productos SET nombre_producto = '" . $nombre . "', categoria_id = '" . $categoria ."', variedad_id = '" . $variedad ."' WHERE id_producto = " . $id . ";";
                if ($conex->query($sql) === TRUE) {
                    echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                } else {
                    echo "Error updating record: " . $conex->error;
                }
                $conex->close();
            }
            ?>


            <!-- !PAGE CONTENT! -->

            <div class="w3-content w3-padding-32 w3-responsive" style="min-height: 722px;">
                <div class="w3-row">
                    <h2 style="text-transform: uppercase;" class="w3-center w3-text-theme"><?php echo $producto['nombre_producto'] ?></h2>
                    <h4 class="w3-center w3-text-theme">Tipo de servicio: <span style="text-transform: capitalize;"><?php echo $producto['nombre_servicio'] ?></span></h4>
                </div>
                <div class="w3-container">
                    <div class="w3-third">
                        <div class="w3-container"></div>
                    </div>
                    <div class="w3-third">
                        <div class="w3-bar">
                            <button class="w3-bar-item w3-button tablink w3-theme-l4" onclick="changeTab(event,'resumen')">Resumen</button>
                            <button class="w3-bar-item w3-button tablink" onclick="changeTab(event,'venta')">Venta</button>
                            <button class="w3-bar-item w3-button tablink" onclick="changeTab(event,'ajustes')">Ajustes</button>
                        </div>
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="actualizarProductos" id="actualizarProductos">

                            <div id="resumen" class="w3-container w3-border w3-theme-l4 w3-border-theme-l4 ficha">
                                <div class="w3-row">
                                    <div class="w3-col w3-padding w3-margin-top w3-margin-bottom w3-round w3-theme-l4">
                                        <!--NOMBRE -->
                                        <div class="w3-container w3-padding w3-round">
                                            <label for="nombre_producto" class="w3-text-theme">Nombre</label>
                                            <input id="nombre_producto" class="w3-input w3-round w3-margin-bottom" type="text" name="nombre_producto" value="<?php echo $producto['nombre_producto']; ?>">
                                        </div>
                                        <!-- VARIEDAD -->
                                        <div class="w3-container w3-padding w3-round">
                                            
                                            <label for="variedad_id" class="w3-text-theme">Variedad</label>
                                            <select name="variedad_id" class="w3-select w3-white w3-round w3-margin-bottom">
                                                <option value="<?php echo $producto['variedad_id'] ?>"><?php echo $producto['nombre_variedad'] ?></option>
                                                <?php
                                                $variedades = getVariedades();
                                                foreach ($variedades as $variedad) :
                                                ?>
                                                <option value="<?php echo $variedad['id_variedad']; ?>"><?php echo $variedad['nombre_variedad'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!--CATEGORÍA -->
                                        <div class="w3-container w3-padding w3-round">
                                            <label for="categoria_id" class="w3-text-theme">Categoría</label>
                                            <select name="categoria_id" class="w3-select w3-white w3-round w3-margin-bottom">
                                                <option value="<?php echo $producto['categoria_id'] ?>"><?php echo $producto['nombre_categoria'] ?></option>
                                                <?php
                                                $categorias = getCategorias();
                                                foreach ($categorias as $categoria) :
                                                ?>
                                                <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['icono'] . ' ' . $categoria['nombre_categoria'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div id="venta" class="w3-container w3-border w3-theme-l4 w3-border-theme-l4 ficha" style="display:none">
                                <div class="w3-row">
                                    <div class="w3-col w3-padding w3-margin-top w3-margin-bottom w3-round w3-theme-l4">
                                        <!-- PVP -->
                                        <div class="w3-container w3-padding w3-round">
                                            <label for="pvp">PVP</label>
                                            <input id="pvp" class="w3-input w3-border w3-round w3-margin-bottom" type="text" name="pvp" value=<?php echo $producto['pvp'] ?>>
                                        </div>
                                        <!-- ACTIVO -->
                                        <div class="w3-container w3-padding w3-round">
                                            <input id="activo" class="w3-check activo" type="checkbox"  name="activo" value="<?php echo $producto['activo']?>">
                                            <label  class="w3-text-theme" for="activo"> Visible</label>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    var check= document.getElementById('activo');
                                    console.log(check);
                                    if (check.value == 1) {
                                        check.setAttribute('checked','');
                                    }
                                </script>
                            </div>

                            <div id="ajustes" class="w3-container w3-border w3-theme-l4 w3-border-theme-l4 ficha" style="display:none">
                                <div class="w3-row">
                                    <div class="w3-col w3-padding w3-margin-top w3-margin-bottom w3-round w3-theme-l4">
                                        <!-- SERVICIO -->
                                        <div class="w3-container w3-padding w3-round">
                                            <label for="servicio_id" class="w3-text-theme">Servicio</label>
                                            <select name="servicio_id" class="w3-select w3-white w3-round w3-margin-bottom">
                                                <option value="<?php echo $producto['servicio_id'] ?>"><?php echo $producto['nombre_servicio'] ?></option>
                                                <?php
                                                $servicios = getServicios();
                                                foreach ($servicios as $servicio) :
                                                ?>
                                                <option value=<?php echo $servicio['id_servicio']; ?>><?php echo $servicio['nombre_servicio'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- BOTE -->
                                         <div id="tara" class="w3-container w3-padding w3-round w3-hide">
                                            <label for="bote" class="w3-text-theme w3-margin-top">Peso del bote</label>
                                            <input id="bote" class="w3-input w3-round w3-margin-bottom" type="text" name="bote" value=<?php echo $producto['bote'] ?>>
                                        </div>
                                    </div>

                                    

                                    <div  class="w3-col w3-padding w3-margin-top w3-margin-bottom">
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="w3-container">
                                <div class="w3-container w3-padding-32 w3-center">
                                    <input type="submit" value="actualizar" name="actualizar" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme"> 
                                    <a href="index.php" class="w3-button w3-border w3-border-theme w3-theme w3-round w3-hover-white w3-hover-text-theme">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
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
                    var servicio = actualizarProductos.servicio_id.value;
                    var categoria = actualizarProductos.categoria_id.value;
                    var variedad;
                    var tara = document.getElementById('tara');
                    switch (servicio) {
                        case "1":
                            tara.classList.remove('w3-hide');
                            break;
                        case "1":
                            tara.classList.remove('w3-hide');
                            break;
                        case "2":
                            break;
                        default:
                            text = "I have never heard of that fruit...";
                    };
                    if (categoria === "hash" || categoria === "weed") {
                        document.getElementById('variedad').classList.remove('w3-hide');
                    } else {
                        actualizarProductos.variedad_id.value = "";
                    }
                }
                service();
            </script>

            <?php
            include '../templates/footer.php';
            ?>