                    <?php
                    $titulo='Borrar variedad';
                    include '../templates/headIndex.php';
                    require '../../conex.php';
                    $variedad = getVariedadesById($_GET['id_variedad']);
                    if(isset($_POST['bajaButton'])){
                        $id_variedad = $variedad['id_variedad'];
                        $sql = "DELETE FROM variedades WHERE id_variedad='$id_variedad'";
                        mysqli_query($conex, $sql);
                        echo "<script>location.replace('index.php');</script>";
                    }
                    ?>
                    <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="borrarVariedad" id="borrarVariedad" >

                        <!-- NOMBRE -->

                        <div class="w3-row">
                            <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                <label for='nombre_variedad' class="w3-text-theme w3-medium">Variedad</label>
                                <input class="w3-input w3-border w3-border-theme-light" type="text" name="nombre_variedad" placeholder="<?php echo $variedad['nombre_variedad']; ?>" value="<?php echo $variedad['nombre_variedad']; ?>">
                            </div>
                        </div>

                        <!-- DESCRIPCION -->

                        <div class="w3-row">
                            <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                <legend for="descripcion_variedad" class="w3-text-theme w3-medium">Descripción</legend>
                                <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_variedad" id="descripcion_variedad" rows="5" placeholder="(Opcional)"><?php echo $variedad['nombre_variedad']; ?></textarea>
                            </div>
                        </div>

                        <!-- ACTIVO -->

                        <div class="w3-row">
                            <div class="w3-col w3-padding w3-margin-top">
                                <label class="switch">
                                    <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $variedad['activo']?>">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- BOTONES NAVEGACIÓN -->

                        <div class="w3-row w3-padding-32 w3-center">
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <a href="index.php" class="w3-btn w3-theme w3-round w3-block w3-hover-orange">Volver</a>
                            </div>
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <input type="submit" value="Eliminar" name="bajaButton" class="w3-btn w3-red w3-round w3-block w3-hover-orange">
                            </div>
                        </div>
                    </form>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                    include '../templates/footer.php';
                    ?>  