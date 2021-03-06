<?php
$titulo = "PRODUCTOS";
include '../templates/header.php';
include '../templates/head_index.php';
?>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
        <thead>
            <tr class="w3-theme">
                <th>ID</th>
                <th style="text-align: left;">Nombre</th>
                <th>Categoria</th>
                <th>Variedad</th>
                <th>PVC</th>
                <th>PVP</th>
                <th>Stock total</th>
                <th>Tipo de venta</th>
                <th>Peso bote</th>
                <th>Cantidad en dispensario</th>
                <th>Editar</th>
                <th>Recargar</th>
                <th>Estado</th>
            </tr>
        </thead>
        <?php
        // require '../../config/functions.php';
        $productos = getProductos();
        foreach ($productos as $producto) :
        ?>
            <tr>
                <td style="width: 5%;"><?php echo $producto['id'] ?></td>
                <td style="width: 10%; text-align:left;"><?php echo $producto['nombre'] ?></td>
                <td style="width: 5%"><?php echo $producto['categoria'] ?></td>
                <td style="width: 5%"><?php echo $producto['variedad'] ?></td>
                <td style="width: 5%"><?php echo $producto['pvc'] ?> €</td>
                <td style="width: 5%"><?php echo $producto['pvp'] ?> €</td>
                <td class="estado" style="width: 7%"><?php echo $producto['cantidad'] + $producto['dispensario'] ?></td>
                <td style="width: 10%"><?php echo $producto['servicio'] ?></td>
                <td style="width: 5%;"><?php echo $producto['bote'] ?></td>
                <td class="estado" style="width: 10%;"><?php echo $producto['dispensario'] ?></td>
                <td style="width: 5%">
                    <a href="update.php?id=<?php echo $producto['id'] ?>">
                        <i class="fas fa-user-edit w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 5%;">
                    <a href="charge.php?id=<?php echo $producto['id'] ?>">
                        <i class="fas fa-balance-scale w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 5%">
                    <a href="show.php?id=<?php echo $producto['id'] ?>">
                        <i class="fas fa-eye w3-text-theme"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<script>
estadoStock();
</script>
<?php
include '../templates/footer.php';
?>