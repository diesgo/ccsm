                <?php
                    $titulo='Borrar categoria';
                    include '../templates/headIndex.php';
                    require '../../conex.php';
                    $categoria = getCategoriasById($_GET['id_categoria']);
                    if(isset($_POST['bajaButton'])){
                        $id_categoria = $categoria['id_categoria'];
                        $sql = "DELETE FROM categorias WHERE id_categoria='$id_categoria'";
                        mysqli_query($conex, $sql);
                        echo "<script>location.replace('index.php');</script>";
                    }
                ?>
                <div class="w3-content">
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="borrarCategoria" id="borrarCategoria" class="w3-theme-l4 w3-round w3-padding">
                    
                        <!-- NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for="nombre" class="w3-text-theme w3-medium">Nombre</label><br>
                                <input class="w3-input w3-border w3-border-theme-light"  name='nombre' type='text' value="<?php echo $categoria['nombre_categoria']; ?>">
                                <small id="info_nombre"></small>
                            </div>
                        </div>

                        <!-- DESCRIPCION -->

                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_categoria" class="w3-text-theme w3-medium">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_categoria" id="descripcion_categoria" rows="5" placeholder="(Opcional)"><?php echo $categoria['descripcion_categoria']; ?></textarea>
                                <small id="info_descripcion_categoria"></small>
                            </div>
                        </div>

                        <!-- ACTIVO -->

                        <div class="w3-row">
                            <div class="w3-col w3-padding w3-margin-top">
                                <label class="switch">
                                    <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $categoria['activo']?>">
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