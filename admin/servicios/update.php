                    <?php
                        $titulo = "Edit Service";
                        include '../templates/header.php';
                        require '../../config/conexion.php';
                        $variedad = getServiciosById($_GET['id']);
                        if (isset($_POST['update'])) {
                            $id = $variedad['id_servicio'];
                            $nombre = $_POST['nombre'];
                            $descripcion = $_POST['descripcion_servicio'];
                            $activo = isset($_POST['activo']) ? "1" : "0";
                            $sql = "UPDATE servicios SET
                            nombre_servicio = '" . $nombre . "',
                            descripcion_servicio = '" . $descripcion ."',
                            activo = '" . $activo ."'
                            WHERE id_servicio = " . $id . ";";
                            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                            echo "<script>location.replace('index.php');</script>";
                            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                        } else {
                            if (!isset($_POST['id_servicio'])) {
                                $sql = "SELECT min(id_servicio) FROM servicios";
                                $result = mysqli_query($conex, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $id = $row['min(id_servicio)'];
                            } else {
                                $id = $_POST["id_servicio"];
                            }
                            $sql = "SELECT * FROM servicios WHERE id_servicio = '$id'";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $nombre = $row['nombre_servicio'];
                            $descripcion = $row['descripcion_servicio'];
                            $activo = $row['activo'];
                        }
                        $sql = "SELECT * FROM servicios";
                        $result = mysqli_query($conex, $sql);
                    ?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

                    <div class="w3-container w3-mobile" style="width: 40%; margin: 0 auto;">
                        <form accept-charset="utf-8" action="#" method="post" name="form" id="form" class="w3-theme-l2 w3-round-xlarge w3-padding">
                            <div class="w3-row">

                                <div class="w3-col w3-padding">
                                    <label for="nombre" class="w3-text-theme-dark w3-medium">Name</label><br>
                                    <input class='w3-input w3-border w3-round-large' name='nombre' id='nombre' type='text' value="<?php echo $variedad['nombre_servicio']; ?>" pattern=[A-Z\sa-z]{3,20} required>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion_servicio" class="w3-text-theme-dark w3-mediun">Description</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light e w3-round-large" name="descripcion_servicio" id="descripcion_servicio" rows="5"><?php echo $variedad['descripcion_servicio'] ?></textarea>
                                </div>

                                
                                <div class="w3-col w3-padding">
                                    <legend for="activo" class="w3-text-theme-dark w3-medium">Visible</legend>
                                    <label class="switch">
                                        <input class="activo custom" type="checkbox"  name="activo" value="<?php echo $variedad['activo'] ?>">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <?php
                                    include '../templates/nav_btn_upd.php';
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