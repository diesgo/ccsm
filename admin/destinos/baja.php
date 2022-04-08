                    <?php
                        $titulo='Borrar destino';
                        include '../templates/header.php';
                        require '../../conex.php';
                        $destino = getDestinosById($_GET['id']);
                        if(isset($_POST['erase'])){
                            $id_destino = $destino['id_destino'];
                            $sql = "DELETE FROM destinos WHERE id_destino='$id_destino'";
                            mysqli_query($conex, $sql);
                            echo "<script>location.replace('index.php');</script>";
                        }
                    ?>
                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for='nombre_destino' class="w3-text-theme-dark w3-medium">Proveedor</label>
                                    <input class="w3-input w3-border w3-round-large" type="text" name="nombre_destino" placeholder="<?php echo $destino['nombre_destino']; ?>" value="<?php echo $destino['nombre_destino']; ?>">
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_destino" class="w3-text-theme-dark w3-medium">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-round-large" name="descripcion_destino" id="descripcion_destino" rows="5" placeholder="(Opcional)"><?php echo $destino['nombre_destino']; ?></textarea>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $destino['activo']?>">
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