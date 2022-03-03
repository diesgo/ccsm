<?php
$titulo = "Editar categoria";
include '../templates/header.php';
$categoria = getCategoriasById($_GET['id_categoria']);
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <?php
        if (isset($_POST['actualizar'])) {
            $id_categoria = $categoria['id_categoria'];
            $nombre_categoria = $_POST['nombre_categoria'];
            $descripcion_categoria = $_POST['descripcion_categoria'];
            $icono = $_POST['icono'];
            $sql = "UPDATE categorias SET nombre_categoria ='" . $nombre_categoria . "',descripcion_categoria='" . $descripcion_categoria . "',icono_id='" . $icono . "' WHERE id_categoria=" . $id_categoria . ";";
            echo "<h3 class='w3-text-green'><i class='w3-xlarge fas fa-check'></i> Cambios guardados</h3>";
            echo "<script>location.replace('index.php');</script>";
            mysqli_query($conex, $sql)            
            or die("Error al ejecutar la consulta");
        } else {
            if (!isset($_POST['id_categoria'])) {
                $sql = "SELECT min(id_categoria) FROM categorias";
                $result = mysqli_query($conex, $sql);
                $row = mysqli_fetch_assoc($result);
                $id_categoria = $row['min(id_categoria)'];
            } else {
                $id_categoria = $_POST["id_categoria"];
            }
            $sql = "SELECT nombre_categoria, descripcion_categoria, icono_id FROM categorias WHERE id_categoria = '$id_categoria'";
            $result = mysqli_query($conex, $sql);
            $row = mysqli_fetch_assoc($result);
            $nombre_categoria = $row['nombre_categoria'];
            $descripcion_categoria = $row['descripcion_categoria'];
            $icono = $row['icono_id'];
        }
        $sql = "SELECT * FROM categorias";
        $result = mysqli_query($conex, $sql);
        ?>
    </div>
</div>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div id="main-div" class="w3-padding">
        <div class="w3-container">
            <form accept-charset="utf-8" action="<?php $PHP_SELF ?>" method="post" name="updateCategoria" id="updateCategoria">
                <!-- FICHA CATEGORIA  -->
                <div class="w3-content w3-padding">

                    <!-- FILA 2: CATEGORIA Y DESCRIPCIÓN -->
                    <div class="w3-row">
                        <!-- CATEGORIA -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for="nombre_categoria" class="w3-text-theme">Categoria</label><br>
                            <input class='w3-input w3-border w3-border-theme w3-round w3-theme-l4' name='nombre_categoria' id='nombre_categoria' type='text' value=<?php echo $categoria['nombre_categoria'] ?>>
                        </div>
                        <!-- DESCRIPCIÓN -->
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <label for="descripcion_categoria" class="w3-text-theme">Descripción</label>
                            <input class="w3-input w3-border w3-border-theme w3-round w3-theme-l4" name="descripcion_categoria" id="descripcion_categoria" type="text" value=<?php echo $categoria['descripcion_categoria'] ?>>
                        </div>
                        <div class="w3-col m4 l4 s12 w3-padding">
                            <?php
                            $iconos = getIcono();
                            ?>
                            <label for="icono" class="w3-text-theme">Icono</label>
                            <select name="icono" id="icono" class="w3-select w3-border w3-border-theme w3-round w3-theme-l4">
                                <option value="<?php echo $categoria['icono_id']; ?>"> <?php echo $categoria['icono'] . ' ' . $categoria['nombre_icono']; ?></option>
                                <?php
                                foreach ($iconos as $icono) :
                                ?>
                                <option value=<?php echo $icono['id_icono']; ?>> <?php echo $icono['icono'] . ' ' . $icono['nombre_icono']; ?></option>
                                <?php endforeach;
                                ?>
                            </select>                           
                        </div>
                    </div>
                </div>
                <div class="w3-row w3-padding-32 w3-center">
                    <input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-theme w3-round">
                    <a href="index.php" class="w3-button w3-theme w3-round">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- !End page content! -->

<?php
include '../templates/footer.php';
?>