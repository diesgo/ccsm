<?php
$titulo="Borrar servicio";
include "../templates/header.php";
$servicio = getserviciosById($_GET['id_servicio']);
?>


            <!-- Header -->

            <div class="w3-container w3-padding-32 w3-theme-l4">
                <div class="w3-half">
                    <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
                <div class="w3-half">
                    <?php
                    if(isset($_POST['bajaButton'])){
                        $id_servicio = $servicio['id_servicio'];
                        $sql = "DELETE FROM servicio WHERE id_servicio='$id_servicio'";
                        mysqli_query($conex, $sql);
                        echo "<script>location.replace('index.php');</script>";
                    }
                    ?>
                </div>
            </div>

            <!-- PAGE CONTENT -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 594px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="borrarServicio" id="borrarServicio" >
                            
                            <!-- FICHA servicio  -->
                            
                            <div class="w3-content">

                                <!-- NOMBRE -->
                                
                                <div class="w3-row">
                                    <div class="w3-col m6 l6 s12 w3-margin-bottom">
                                        <label for='nombre_servicio' class="w3-text-theme w3-medium">Servicio</label>
                                        <input class="w3-input w3-border w3-border-theme-light" type="text" name="nombre_servicio" placeholder="<<?php echo $servicio['nombre_servicio']; ?>" value="<?php echo $servicio['nombre_servicio']; ?>">
                                    </div>
                                </div>
                                
                                <!-- DESCRIPCION -->

                                <div class="w3-row">
                                    <div class="w3-col m12 l12 s12 w3-margin-top w3-margin-bottom">
                                        <legend for="descripcion_servicio" class="w3-text-theme w3-medium">Descripción</legend>
                                        <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_servicio" id="descripcion_servicio" rows="5" placeholder="(Opcional)"><?php echo $servicio['nombre_servicio']; ?></textarea>
                                        <small id="info_descripcion_servicio"></small>
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