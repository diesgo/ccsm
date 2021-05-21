<?php
$titulo = "MOSTRAR CATEGORIA";
include '../templates/header.php';
?>
<?php
require_once '../../config/functions.php';
$categoria = getCategoriasById($_GET['id']);
?>

<!-- Header -->

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $titulo ?></b></h2>
    </div>
    <div class="w3-half">
    </div>
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
            <?php
            require '../../config/conexion.php';

            $sql = "SELECT * FROM productos WHERE categoria='" . $categoria['nombre'] . "'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td style='width: 5%;'> " . $row["id"] . "</td>";
                    echo "<td style='width: 15%;'> " . $row["nombre"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["variedad"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["pvc"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["pvp"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["cantidad"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["disp"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["bote"] . "</td>";
                    echo "<td style='width: 5%;'> ";
                    echo "<a href='../productos/update.php?id=" . $row['id'] ."'>";
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
                echo "0 results";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div>

</div>

<?php
include '../templates/footer.php';
?>