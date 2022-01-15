<?php
$titulo = "DISPENSARIO";
include "../templates/header.php"
?>
<div id="pantalla" class="w3-container">

    <!-- !PAGE CONTENT! -->

    <div class="w3-container w3-padding-64 w3-responsive">
        <table class="w3-table w3-striped w3-bordered w3-border w3-border-theme w3-centered">
            <thead>
                <tr class="w3-theme">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Variedad</th>
                    <th>PVC</th>
                    <th>PVP</th>
                    <th>Cantidad</th>
                    <th>Tipo de venta</th>
                    <th>Editar</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <?php
            require '../config/functions.php';
            $productos = getProductos();
            foreach ($productos as $producto) :
            ?>
                <tr>
                    <td style="width: 10%;"><?php echo $producto['id'] ?></td>
                    <td style="width: 10%"><?php echo $producto['nombre'] ?></td>
                    <td style="width: 10%"><?php echo $producto['categoria'] ?></td>
                    <td style="width: 10%"><?php echo $producto['variedad'] ?></td>
                    <td style="width: 10%"><?php echo $producto['pvc'] ?> €</td>
                    <td style="width: 10%"><?php echo $producto['pvp'] ?> €</td>
                    <td style="width: 10%"><?php echo $producto['cantidad'] ?> Kg.</td>
                    <td style="width: 10%"><?php echo $producto['servicio'] ?></td>
                    <td style="width: 10%">
                        <a href="update.php?id=<?php echo $producto['id'] ?>">
                            <i class="fas fa-user-edit w3-text-theme"></i>
                        </a>
                    </td>
                    <td style="width: 10%">
                        <a href="show.php?id=<?php echo $producto['id'] ?>">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php
include "../templates/footer.php";
?>