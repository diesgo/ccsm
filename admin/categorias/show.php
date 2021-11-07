<?php
$titulo = "MOSTRAR CATEGORIA";
include '../templates/header.php';
require_once '../../config/functions.php';
$categoria = getCategoriasById($_GET['id']);
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $categoria['nombre'] ?></b></h2>
    </div>
    <div class="w3-half">
    </div>
</div>

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">

    <!-- <div class="w3-container w3-center">

        <div class="w3-row w3-border w3-border-theme">

            <div class="w3-col l2 m2 w3-padding">
                <p><i class="<?php echo $categoria['icono']; ?> w3-text-theme  w3-xxxlarge"></i></p>
            </div>
            <div class="w3-col l2 m2 w3-padding">
                <p class="w3-text-theme w3-xlarge">Categoría # <span><?php echo $categoria['id']; ?></span></p>
            </div>
            <div class="w3-col l3 m3 w3-padding">
                <p class="w3-text-theme w3-xlarge">Nombre: <span class="w3-text-grey"><?php echo $categoria['nombre']; ?></span></p>
            </div>
            <div class="w3-col l3 m3 w3-padding">
                <p class="w3-text-theme w3-xlarge">Descripción: <span class="w3-text-grey"><?php echo $categoria['descripcion']; ?></span></p>
            </div>
            <div class="w3-col l2 m2 w3-padding w3-margin-top">
                <a href="update.php?id=<?php echo $categoria['id'] ?>" class="w3-button w3-theme w3-round">Editar</a>
            </div>
        </div>
    </div> -->

    <div class="w3-container">
        <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
            <thead>
                <tr class="w3-theme">
                    <th>ID</th>
                    <th style="text-align:left">Nombre</th>
                    <th>Variedad</th>
                    <th>PVC</th>
                    <th>PVP</th>
                    <th>Stock total</th>
                    <th>Tipo de venta</th>
                    <th>cantidad dispensario</th>
                    <th>Peso bote</th>
                    <th>Editar</th>
                    <th>Recargar</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <?php
            require '../../config/conexion.php';

            $sql = "SELECT * FROM productos WHERE categoria='" . $categoria['nombre'] . "'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $cantidad = $row["cantidad"] + $row['dispensario'];
                    echo "<tr>";
                    echo "<td style='width: 5%;'> " . $row["id"] . "</td>";
                    echo "<td style='width: 10%; text-align: left;'> " . $row["nombre"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["variedad"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["pvc"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["pvp"] . "</td>";
                    echo "<td class='estado' style='width: 5%;'> " . $cantidad . "</td>";
                    echo "<td style='width: 8%;'> " . $row["servicio"] . "</td>";
                    echo "<td class='estado' style='width: 8%;'> " . $row["dispensario"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["bote"] . "</td>";
                    echo "<td style='width: 5%;'> ";
                    echo "<a href='../productos/update.php?id=" . $row['id'] . "'>";
                    echo "<i class='fas fa-user-edit w3-text-theme'></i>";
                    echo "</a></td>";
                    echo "<td style='width: 5%;'>";
                    echo "<a href='../productos/charge.php?id=" . $row['id'] . "'>";
                    echo "<i class='fas fa-balance-scale w3-text-theme'></i>";
                    echo "</a></td>";
                    echo "<td style='width: 5%'>";
                    echo "<a href='../productos/show.php?id=" . $row['id'] . "'>";
                    echo "<i class='fas fa-eye w3-text-theme'></i>";
                    echo "</a></td></tr>";
                }
            } else {
                echo "No se han encontrado productos de esta categoría.";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div>

</div>
<script>
    estadoStock();
</script>

<?php
include '../templates/footer.php';
?>