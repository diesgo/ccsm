<?php
$titulo = "Editar categoria";
include '../templates/header.php';
require "../../conex.php";
?>

            <!-- Header -->
            
            <div class="w3-container w3-padding-32 w3-theme-l4">
                <div class="w3-half">
                    <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
                <div class="w3-half">
                    <?php
                    $categoria = getCategoriasById($_GET['id_categoria']);
                    if (isset($_POST['actualizar'])) {
                        $id = $categoria['id_categoria'];
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion_categoria'];
                        $icono = $_POST['icono_id'];
                        $activo = isset($_POST['activo']) ? "1" : "0";
                        $sql = "UPDATE categorias SET nombre_categoria = '" . $nombre . "', descripcion_categoria = '" . $descripcion ."', icono_id = '" . $icono ."', activo = '" . $activo ."' WHERE id_categoria = " . $id . ";";
                        echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                        echo "<script>location.replace('index.php');</script>";
                        mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                    } else {
                        if (!isset($_POST['id_categoria'])) {
                            $sql = "SELECT min(id_categoria) FROM categorias";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['min(id_categoria)'];
                        } else {
                            $id = $_POST["id_categoria"];
                        }
                        $sql = "SELECT * FROM categorias WHERE id_categoria = '$id'";
                        $result = mysqli_query($conex, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $nombre = $row['nombre_categoria'];
                        $descripcion = $row['descripcion_categoria'];
                        $icono = $row['icono_id'];
                        $activo = $row['activo'];
                    }
                    $sql = "SELECT * FROM categorias";
                    $result = mysqli_query($conex, $sql);

                    ?>
                </div>
                
            </div>

            <!-- !PAGE CONTENT! -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario">
                            
                            <!-- FICHA CATEGORIA  -->
                            
                            <div class="w3-content">

                                <div class="w3-row">

                                    <!-- NOMBRE -->
                                    
                                    <div class="w3-col m6 l6 s12 w3-padding w3-margin-bottom">
                                        <label for="nombre" class="w3-text-theme">Nombre</label><br>
                                        <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $categoria['nombre_categoria']; ?>">
                                        <small id="info_nombre"></small>
                                    </div>

                                    <!-- ICONO -->

                                    <div class="w3-col m6 l6 s12 w3-padding">
                                        <label for="icono_id" class="w3-text-theme">Icono</label>
                                        <select name="icono_id" id="icono_id" class="w3-select w3-border w3-white">
                                            <option value=<?php echo $categoria['icono_id']; ?>> <?php echo $categoria['icono'] . ' ' . $categoria['nombre_icono']; ?></option>
                                            <?php
                                            $iconos = getIcono();
                                            foreach ($iconos as $icono) :
                                            ?>
                                            <option value=<?php echo $icono['id_icono']; ?>> <?php echo $icono['icono'] . ' ' . $icono['nombre_icono']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>

                                <!-- DESCRIPCIÓN -->
                                
                                <div class="w3-row">
                                    <div class="w3-col m12 l12 s12 w3-padding w3-margin-top w3-margin-bottom">
                                        <legend for="descripcion_categoria" class="w3-text-theme w3-mediun">Descripción</legend>
                                        <textarea class="w3-block w3-border w3-border-theme-light" name="descripcion_categoria" id="descripcion_categoria" rows="5"><?php echo $categoria['descripcion_categoria'] ?></textarea>
                                        <small id="info_descripcion_categoria"></small>
                                    </div>
                                </div>

                                <!-- ACTIVO -->

                                <div class="w3-row">
                                    <div class="w3-col m5 l6 s12 w3-padding w3-margin-top">
                                        <input id="activo" class="w3-check" type="checkbox"  name="activo" value="<?php echo $categoria['activo']?>">
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
                                <div class="w3-row w3-padding w3-center w3-margin-top">
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