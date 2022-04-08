                    <?php
                        $titulo = "Editar rol";
                        include '../templates/header.php';
                        require '../../config/conexion.php';
                        $rol = getRolesById($_GET['id']);
                        if (isset($_POST['update'])) {
                            $id = $rol['id_rol'];
                            $nombre = $_POST['nombre'];
                            $descripcion = $_POST['descripcion_rol'];
                            $activo = isset($_POST['activo']) ? "1" : "0";
                            $sql = "UPDATE roles SET
                            nombre_rol = '" . $nombre . "',
                            descripcion_rol = '" . $descripcion ."',
                            activo = '" . $activo ."'
                            WHERE id_rol = " . $id . ";";
                            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                            echo "<script>location.replace('index.php');</script>";
                            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                        } else {
                            if (!isset($_POST['id_rol'])) {
                                $sql = "SELECT min(id_rol) FROM roles";
                                $result = mysqli_query($conex, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $id = $row['min(id_rol)'];
                            } else {
                                $id = $_POST["id_rol"];
                            }
                            $sql = "SELECT * FROM roles WHERE id_rol = '$id'";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $nombre = $row['nombre_rol'];
                            $descripcion = $row['descripcion_rol'];
                            $activo = $row['activo'];
                        }
                        $sql = "SELECT * FROM roles";
                        $result = mysqli_query($conex, $sql);
                    ?>

                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for="nombre" class="w3-text-theme-dark w3-medium">Nombre</label><br>
                                    <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $rol['nombre_rol']; ?>" pattern=[A-Z\sa-z]{3,20}>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_rol" class="w3-text-theme-dark w3-mediun">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_rol" id="descripcion_rol" rows="5"><?php echo $rol['descripcion_rol'] ?></textarea>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $rol['activo'] ?>">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                            </div>

                            <?php
                                include '../templates/navbtn.php';
                            ?>
                        </form>

                    </div>
                </div>

                <script>
                    captarCheckbox();
                </script>
                <?php
                    include '../templates/footer.php';
                ?>