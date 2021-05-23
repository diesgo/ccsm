<?php
$titulo = "DISPENSARIO";
include "../templates/header.php"
?>
<div id="pantalla" class="w3-container">
    <div class="w3-content">
        <?php
        require_once '../config/functions.php';
        $categorias = getCategorias();
        foreach ($categorias as $categoria) :
        ?>
            <div class="w3-quarter w3-padding">
                <div class="w3-container w3-padding w3-center">
                    <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="dispensar.php?id=<?php echo $categoria['id'] ?>" style="text-decoration:none; width: 150px; padding: 32px 16px;">
                        <i class="<?php echo $categoria['icono']; ?> w3-jumbo"></i>
                        <p><?php echo $categoria['nombre']; ?></p>
                    </a>
                </div>
            </div>


        <?php endforeach; ?>

        <!-- Socios -->

        <div class="w3-quarter w3-padding">
            <div class="w3-container w3-padding w3-center">
                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="admin/socios/gestionarSocios.php" style="text-decoration:none; width: 150px; padding: 32px 16px;">
                    <i class="fas fa-user-cog w3-jumbo"></i>
                    <p>Socios</p>
                </a>
            </div>
        </div>

        <!-- Administración -->

        <div class="w3-quarter w3-padding">
            <div class="w3-container w3-padding w3-center">
                <a class="w3-border w3-border-green w3-round w3-white w3-hover-green  w3-text-green w3-button" href="admin/index.php" style="text-decoration:none; width: 150px; padding: 32px 16px;">
                    <i class="fas fa-cogs w3-jumbo"></i>
                    <p>Administración</p>
                </a>
            </div>
        </div>
    </div>
</div>
<?php
include "../templates/footer.php";
?>