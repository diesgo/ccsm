<?php
$titulo = "MOSTRAR CATEGORIA";
include '../templates/header.php';
?>

<?php require_once '../../config/functions.php';
 $categoria = getCategoriasById($_GET['id']);
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">

    </div>
    <hr>
</div>

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <div class="w3-display-container w3-padding w3-center" style="height: 200px;">
        <div class="w3-display-middle  w3-border w3-round w3-border-theme">
            <div class="w3-cell w3-padding-large w3-center">
                <p><i class="<?php echo $categoria['icono']; ?> w3-text-theme  w3-jumbo"></i></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <p class="w3-text-theme w3-xlarge">Categoría # <span><?php echo $categoria['id']; ?></span></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <p class="w3-text-theme w3-large">Nombre: <span class="w3-text-grey"><?php echo $categoria['nombre']; ?></span></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <p class="w3-text-theme w3-large">Descripción: <span class="w3-text-grey"><?php echo $categoria['descripcion']; ?></span></p>
            </div>
            <div class="w3-cell w3-padding-large w3-center">
                <a href="update.php?id=<?php echo $categoria['id'] ?>" class="w3-button w3-theme w3-round">Editar</a>
            </div>
        </div>
    </div>

    <div class="w3-container w3-padding w3-responsive">
        <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
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
                    <th>Peso bote</th>
                    <th>Editar</th>
                    <th>Recargar</th>
                    <th>Estado</th>
                </tr>
            </thead>
        
   
                <!-- <tr>
                    <td style="width: 5%;"><?php echo $producto['id'] ?></td>
                    <td style="width: 15%"><?php echo $producto['nombre'] ?></td>
                    <td style="width: 5%"><?php echo $producto['categoria'] ?></td>
                    <td style="width: 5%"><?php echo $producto['variedad'] ?></td>
                    <td style="width: 5%"><?php echo $producto['pvc'] ?> €</td>
                    <td style="width: 5%"><?php echo $producto['pvp'] ?> €</td>
                    <td style="width: 5%"><?php echo $producto['cantidad'] ?> Kg.</td>
                    <td style="width: 5%"><?php echo $producto['disp'] ?></td>
                    <td style="width: 5%;"><?php echo $producto['bote'] ?></td>
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
                </tr> -->
            
        </table>
    </div>

</div>

<?php
include '../templates/footer.php';
?>