<?php
$titulo = "EDITAR VARIEDADES";
include '../templates/header.php';
?>

            <!-- Header -->
            
            <div class="w3-container w3-padding-32 w3-theme-l4">
                <div class="w3-half">
                    <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
                <div class="w3-half">
                    <?php
                    $variedad = getVariedadesById($_GET['id_variedad']);
                    if (isset($_POST['actualizar'])) {
                        $id = $variedad['id_variedad'];
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion_variedad'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        $sql = "UPDATE variedades SET nombre_variedad = '" . $nombre . "', descripcion_variedad = '" . $descripcion ."', activo = '" . $activo ."' WHERE id_variedad = " . $id . ";";
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
                </div>
                
            </div>

            <!-- !PAGE CONTENT! -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">
                            
                            <!-- FICHA VARIEDAD  -->
                            
                            <div class="w3-content">
                                
                                <!-- NOMBRE -->

                                <div class="w3-row">
                                    <div class="w3-col m6 l6 s12 w3-margin-bottom">
                                        <label for="nombre" class="w3-text-theme">Nombre</label><br>
                                        <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $variedad['nombre_variedad']; ?>">
                                        <small id="info_nombre"></small>
                                    </div>
                                </div>

                                <!-- DESCRIPCIÓN -->
                                
                                <div class="w3-row">
                                    <div class="w3-col m12 l12 s12 w3-margin-top w3-margin-bottom">
                                        <legend for="descripcion_variedad" class="w3-text-theme w3-mediun">Descripción</legend>
                                        <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_variedad" id="descripcion_variedad" rows="5"><?php echo $variedad['descripcion_variedad'] ?></textarea>
                                        <small id="info_descripcion_variedad"></small>
                                    </div>
                                </div>

                                <!-- ACTIVO -->

                                <div class="w3-row">
                                    <!-- <?php $check = isset($variedad['activo']) ?  : "checked"?> -->
                                    <div class="w3-col m5 l6 s12 w3-margin-top">
                                        <input id="activo" class="w3-check" type="checkbox"  name="activo" value="<?php echo $variedad['activo']?>">
                                        <label class="w3-text-theme w3-medium" for="activo">Activo</label></p>
                                    </div>
                                </div>
                            </div>
                            <script>
                                var check= document.getElementById('activo');
                                console.log(check);
                                if (check.value == 1) {
                                    check.setAttribute('checked','');                                    
                                }
                            </script>

                            <!-- BOTONES DE NAVEGACIÓN -->

                            <div class="w3-content">
                                <div class="w3-row w3-padding-32 w3-center w3-margin-top">
                                    <a href="index.php" class="w3-button w3-theme w3-round w3-left">Volver</a>
                                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-green w3-round w3-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- !End page content! -->
            <?php
            include '../templates/footer.php';
            ?>