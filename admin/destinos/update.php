                    <?php
                        $titulo = "Editar destino";
                        include '../templates/header.php';
                        require '../../config/conexion.php';
                        $destino = getDestinosById($_GET['id']);
                        if (isset($_POST['update'])) {
                            $id = $destino['id_destino'];
                            $nombre = $_POST['nombre'];
                            $descripcion = $_POST['descripcion_destino'];
                            $activo = isset($_POST['activo']) ? "1" : "0";
                            $sql = "UPDATE destinos SET
                            nombre_destino = '" . $nombre . "',
                            descripcion_destino = '" . $descripcion ."',
                            activo = '" . $activo ."'
                            WHERE id_destino = " . $id . ";";
                            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                            echo $sql;
                            // echo "<script>location.replace('index.php');</script>";
                            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                        } else {
                            if (!isset($_POST['id_destino'])) {
                                $sql = "SELECT min(id_destino) FROM destinos";
                                $result = mysqli_query($conex, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $id = $row['min(id_destino)'];
                            } else {
                                $id = $_POST["id_destino"];
                            }
                            $sql = "SELECT * FROM destinos WHERE id_destino = '$id'";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $nombre = $row['nombre_destino'];
                            $descripcion = $row['descripcion_destino'];
                            $activo = $row['activo'];
                        }
                        $sql = "SELECT * FROM destinos";
                        $result = mysqli_query($conex, $sql);

                    ?>

                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for="nombre" class="w3-text-theme-dark">Nombre</label><br>
                                    <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $destino['nombre_destino']; ?>" pattern=[A-Z\sa-z]{3,20}>
                                    <small id="info_nombre"></small>
                                </div>
                                
                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_destino" class="w3-text-theme-dark w3-mediun">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_destino" id="descripcion_destino" rows="5"><?php echo $destino['descripcion_destino'] ?></textarea>
                                    <small id="info_descripcion_destino"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $destino['activo'] ?>" pattern="[a-zA-Z0-9]+">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                            </div>

                            <?php
                                include '../templates/nav_btn_upd.php';
                            ?>

                        </form>
                    </div>
                    <script>
                        captarCheckbox();
                    </script>
                    <?php
                        include '../templates/footer.php';
                    ?>