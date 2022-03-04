<?php
$titulo='Borrar variedad';
include '../templates/header.php';
$variedad = getVariedadesById($_GET['id_variedad']);
?>


            <!-- Header -->

            <div class="w3-container w3-padding-32 w3-theme-l4">
                <div class="w3-half">
                    <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
                <div class="w3-half">
                    <?php
                    if(isset($_POST['bajaButton'])){
                        $id_variedad = $variedad['id_variedad'];
                        $sql = "DELETE FROM variedades WHERE id_variedad='$id_variedad'";
                        mysqli_query($conex, $sql);
                        echo "<script>location.replace('index.php');</script>";
                    }
                    ?>
                </div>
            </div>

            <!-- PAGE CONTENT -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="borrarVariedad" id="borrarVariedad" >
                            
                            <!-- FICHA VARIEDAD  -->
                            
                            <div class="w3-content">

                                <!-- NOMBRE -->
                                
                                <div class="w3-row">
                                    <div class="w3-col m6 l6 s12 w3-margin-bottom">
                                        <label for='nombre_variedad' class="w3-text-theme w3-medium">Variedad</label>
                                        <input class="w3-input w3-border w3-border-theme-light" type="text" name="nombre_variedad" placeholder="<<?php echo $variedad['nombre_variedad']; ?>" value="<?php echo $variedad['nombre_variedad']; ?>">
                                    </div>
                                </div>
                                
                                <!-- DESCRIPCION -->

                                <div class="w3-row">
                                    <div class="w3-col m12 l12 s12 w3-margin-top w3-margin-bottom">
                                        <legend for="descripcion_variedad" class="w3-text-theme w3-medium">Descripción</legend>
                                        <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_variedad" id="descripcion_variedad" rows="5" placeholder="(Opcional)"><?php echo $variedad['nombre_variedad']; ?></textarea>
                                        <small id="info_descripcion_variedad"></small>
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