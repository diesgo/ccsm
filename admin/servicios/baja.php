                    <?php
                        $titulo='Borrar servicio';
                        include '../templates/header.php';
                        require '../../conex.php';
                        $servicio = getServiciosById($_GET['id']);
                        if(isset($_POST['erase'])){
                            $id_servicio = $servicio['id_servicio'];
                            $sql = "DELETE FROM servicios WHERE id_servicio='$id_servicio'";
                            mysqli_query($conex, $sql);
                            echo "<script>location.replace('index.php');</script>";
                        }
                    ?>

                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for='nombre_servicio' class="w3-text-theme-dark w3-medium">Servicio</label>
                                    <input class="w3-input w3-border w3-border-theme-light w3-round-large" type="text" name="nombre_servicio" placeholder="<?php echo $servicio['nombre_servicio']; ?>" value="<?php echo $servicio['nombre_servicio']; ?>">
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_servicio" class="w3-text-theme-dark w3-medium">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light w3-round-large" name="descripcion_servicio" id="descripcion_servicio" rows="5" placeholder="(Opcional)"><?php echo $servicio['nombre_servicio']; ?></textarea>
                                    <small id="info_descripcion_servicio"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $servicio['activo']?>">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                            </div>

                            <?php
                                include '../templates/nav_btn_erase.php';
                            ?>

                        </form>
                    </div>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                        include '../templates/footer.php';
                    ?>