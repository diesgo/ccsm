                    <?php
                        $titulo='Borrar variedad';
                        include '../templates/header.php';
                        require '../../conex.php';
                        $variedad = getVariedadesById($_GET['id']);
                        if(isset($_POST['erase'])){
                            $id_variedad = $variedad['id_variedad'];
                            $sql = "DELETE FROM variedades WHERE id_variedad='$id_variedad'";
                            mysqli_query($conex, $sql);
                            echo "<script>location.replace('index.php');</script>";
                        }
                    ?>
                
                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for='nombre_variedad' class="w3-text-theme-dark w3-medium">Variedad</label>
                                    <input class="w3-input w3-border w3-border-theme-light w3-round-large" type="text" name="nombre_variedad" placeholder="<?php echo $variedad['nombre_variedad']; ?>" value="<?php echo $variedad['nombre_variedad']; ?>">
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_variedad" class="w3-text-theme-dark w3-medium">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light w3-round-large" name="descripcion_variedad" id="descripcion_variedad" rows="5" placeholder="(Opcional)"><?php echo $variedad['nombre_variedad']; ?></textarea>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $variedad['activo']?>">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <?php
                                    include '../templates/nav_btn_erase.php';
                                ?>
                            </div>
                        </form>
                    </div>
                
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                    include '../templates/footer.php';
                    ?>  