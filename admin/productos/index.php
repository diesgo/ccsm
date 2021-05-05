<?php
$titulo = "Productos";
include '../templates/header.php';
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2><b><i class="fa fa-dashboard"></i><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
        <a class="w3-right w3-button w3-theme-dark w3-border w3-border-theme-dark w3-round w3-hover-white w3-hover-theme-dark w3-hover-text-theme-dark" href="create.php">+ Nuevo producto</a>
    </div>
    <hr>
</div>

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
        require '../../config/functions.php';
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
                <td style="width: 10%"><?php echo $producto['disp'] ?></td>
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
<?php
include '../templates/footer.php';
?>