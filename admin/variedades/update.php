                    <?php
                        $titulo = "Editar variedad";
                        include '../templates/header.php';
                        require '../../config/conexion.php';
                        $variedad = getVariedadesById($_GET['id']);
                        if (isset($_POST['update'])) {
                            $id = $variedad['id_variedad'];
                            $nombre = $_POST['nombre'];
                            $descripcion = $_POST['descripcion'];
                            $activo = isset($_POST['activo']) ? "1" : "0";
                            $sql = "UPDATE variedades SET
                            nombre_variedad = '" . $nombre . "',
                            descripcion_variedad = '" . $descripcion ."',
                            activo = '" . $activo ."' WHERE id_variedad = " . $id . ";";
                            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                            echo "<script>location.replace('index.php');</script>";
                            mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                        } else {
                            if (!isset($_POST['id_variedad'])) {
                                $sql = "SELECT min(id_variedad) FROM variedades";
                                $result = mysqli_query($conex, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $id = $row['min(id_variedad)'];
                            } else {
                                $id = $_POST["id_variedad"];
                            }
                            $sql = "SELECT * FROM variedades WHERE id_variedad = '$id'";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $nombre = $row['nombre_variedad'];
                            $descripcion = $row['descripcion_variedad'];
                            $activo = $row['activo'];
                        }
                        $sql = "SELECT * FROM variedades";
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
                                    <label for="nombre" class="w3-text-theme-dark w3-medium">Nombre</label><br>
                                    <input class='w3-input w3-border w3-round-large' name='nombre' id='nombre' type='text' value="<?php echo $variedad['nombre_variedad']; ?>" pattern=[A-Z\sa-z]{3,20}>
                                    <small id="info_nombre"></small>
                                </div>

                                <div class="w3-col w3-padding">
                                    <legend for="descripcion" class="w3-text-theme-dark w3-mediun">Descripción</legend>
                                    <textarea class="w3-block w3-border w3-border-theme-light w3-round-large" name="descripcion" id="descripcion" rows="5"><?php echo $variedad['descripcion_variedad'] ?></textarea>
                                    <small id="info_descripcion_variedad"></small>
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