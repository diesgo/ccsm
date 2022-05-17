<?php
$titulo='Borrar usuario';
include '../templates/header.php';
$user = getUsersById($_GET['id_user']);
?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

            <!-- Header -->

            <div class="w3-container w3-padding-32 w3-theme-l4">
                <div class="w3-half">
                    <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
                <div class="w3-half">
                    <?php
                    if(isset($_POST['bajaButton'])){
                        $id_user = $user['id_user'];
                        $sql = "DELETE FROM users WHERE id_user='$id_user'";
                        mysqli_query($conex, $sql);
                        // echo "<script>location.replace('index.php');</script>";
                    }
                    ?>
                </div>
            </div>

            <!-- PAGE CONTENT -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="borraruser" id="borraruser" class="w3-theme-l4 w3-round w3-padding">
                            
                            <!-- FICHA SERVICIO  -->
                            
                            <div class="w3-content">

                                <!-- NOMBRE -->
                                
                                <div class="w3-row">
                                    <div class="w3-col m6 l6 s12 w3-margin-bottom">
                                        <label for='nombre_user' class="w3-text-theme w3-medium">Servicio</label>
                                        <input class="w3-input w3-border w3-border-theme-light" type="text" name="nombre_user" placeholder="<?php echo $user['nombre_user']; ?>" value="<?php echo $user['nombre_user']; ?>">
                                    </div>
                                </div>
                                
                                <!-- DESCRIPCION -->

                                <div class="w3-row">
                                    <div class="w3-col m12 l12 s12 w3-margin-top w3-margin-bottom">
                                        <legend for="descripcion_user" class="w3-text-theme w3-medium">Descripción</legend>
                                        <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_user" id="descripcion_user" rows="5" placeholder="(Opcional)"><?php echo $user['nombre_user']; ?></textarea>
                                        <small id="info_descripcion_user"></small>
                                    </div>
                                </div>

                                <!-- ACTIVO -->

                                <div class="w3-row">
                                    <div class="w3-col m5 l6 s12 w3-margin-top">
                                        <input class="w3-check" type="checkbox" id="activo" name="activo">
                                        <label for="activo" class="w3-text-theme w3-medium">Activo</label>
                                    </div>
                                </div>
                            
                                <!-- BOTONES DE NAVEGACIÓN -->
                            
                                <div class="w3-content">
                                    <div class="w3-row w3-padding-32 w3-center w3-margin-top">
                                        <a href="index.php" class="w3-button w3-theme w3-round w3-left">Volver</a>
                                        <input type="submit" value="Eliminar" name="bajaButton" id="bajaButton" class="w3-button w3-red w3-round w3-right"  >
                                    </div>
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