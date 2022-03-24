                <?php
                    $titulo='Borrar proveedor';
                    include '../templates/headIndex.php';
                    require '../../conex.php';
                    $proveedor = getProveedoresById($_GET['id_proveedor']);
                    if(isset($_POST['bajaButton'])){
                        $id_proveedor = $proveedor['id_proveedor'];
                        $sql = "DELETE FROM proveedores WHERE id_proveedor='$id_proveedor'";
                        mysqli_query($conex, $sql);
                        echo "<script>location.replace('index.php');</script>";
                    }
                ?>
                <div class="w3-content">
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="borrar_proveedor" id="borrar_proveedor" class="w3-theme-l4 w3-round w3-padding">

                        <!-- NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for='nombre_proveedor' class="w3-text-theme w3-medium">Proveedor</label>
                                <input class="w3-input w3-border w3-border-theme-light" type="text" name="nombre_proveedor" placeholder="<?php echo $proveedor['nombre_proveedor']; ?>" value="<?php echo $proveedor['nombre_proveedor']; ?>">
                            </div>
                        </div>

                        <!-- DESCRIPCION -->

                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_proveedor" class="w3-text-theme w3-medium">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_proveedor" id="descripcion_proveedor" rows="5" placeholder="(Opcional)"><?php echo $proveedor['nombre_proveedor']; ?></textarea>
                                <small id="info_descripcion_proveedor"></small>
                            </div>
                        </div>

                        <!-- ACTIVO -->

                        <div class="w3-row">
                            <div class="w3-col w3-padding w3-margin-top">
                                <label class="switch">
                                    <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $proveedor['activo']?>">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- BOTONES NAVEGACIÓN -->

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