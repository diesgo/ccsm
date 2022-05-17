<?php
$titulo = "EDITAR USUARIO";
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
                    $user = getUsersById($_GET['id_user']);
                    if (isset($_POST['actualizar'])) {
                        $id = $user['id_user'];
                        $username = $_POST['username'];
                        $sql = "UPDATE users SET username = '" . $username . "' WHERE id_user = " . $id . ";";
                        echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Los cambios se han guardado satisfactoriamente</h3>";
                        echo "<script>location.replace('index.php');</script>";
                        mysqli_query($conex, $sql) or die("Error al ejecutar la consulta");
                    } else {
                        if (!isset($_POST['id_user'])) {
                            $sql = "SELECT min(id_user) FROM users";
                            $result = mysqli_query($conex, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['min(id_user)'];
                        } else {
                            $id = $_POST["id_user"];
                        }
                        $sql = "SELECT * FROM users WHERE id_user = '$id'";
                        $result = mysqli_query($conex, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $username = $row['username'];
                    }
                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($conex, $sql);

                    ?>
                </div>
                
            </div>

            <!-- !PAGE CONTENT! -->

            <div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">
                <div id="main-div" class="w3-padding">
                    <div class="w3-container">
                        <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="formulario" id="formulario" class="w3-theme-l4 w3-round w3-padding">
                            
                            <!-- FICHA SERVICIO  -->
                            
                            <div class="w3-content">
                                
                                <!-- NOMBRE -->

                                <div class="w3-row">
                                    <div class="w3-col m6 l6 s12 w3-margin-bottom">
                                        <label for="nombre" class="w3-text-theme">Nombre</label><br>
                                        <input class='w3-input w3-border w3-round' name='nombre' id='nombre' type='text' value="<?php echo $user['username']; ?>">
                                        <small id="info_nombre"></small>
                                    </div>
                                </div>

                            </div>

                            <!-- BOTONES DE NAVEGACIÓN -->

                        <div class="w3-row w3-padding-32 w3-center">
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <a href="index.php" class="w3-btn w3-theme w3-round w3-hover-green w3-block">Volver</a>
                            </div>
                            <div class="w3-col l6 m6 s12 w3-padding-large">
                                <input type="submit" value="Actualizar" name="actualizar" class="w3-btn w3-theme w3-round w3-hover-orange w3-block">
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