<?php
$titulo = "MOSTRAR CATEGORIA";
include '../templates/header.php';
$categoria = getCategoriasById($_GET['id']);
?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>

<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><?php echo $categoria['nombre_categoria'] ?></b></h2>
    </div>
    <div class="w3-half">
    </div>
</div>

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 616px;">

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
            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
            $sql = "SELECT * FROM productos INNER JOIN servicios ON id_servicio = servicio_id INNER JOIN variedades ON id_variedad = variedad_id WHERE categoria_id='" . $categoria['id_categoria'] . "'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $cantidad = $row["cantidad"] + $row['dispensario'];
                    echo "<tr>";
                    echo "<td style='width: 5%;'> " . $row["id_producto"] . "</td>";
                    echo "<td style='width: 10%; text-align: left;'> " . $row["nombre_producto"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["nombre_variedad"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["pc"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["pvp"] . "</td>";
                    echo "<td class='estado' style='width: 5%;'> " . $cantidad . "</td>";
                    echo "<td style='width: 8%;'> " . $row["nombre_servicio"] . "</td>";
                    echo "<td class='estado' style='width: 8%;'> " . $row["dispensario"] . "</td>";
                    echo "<td style='width: 5%;'> " . $row["bote"] . "</td>";
                    echo "<td style='width: 5%;'> ";
                    echo "<a href='../productos/update.php?id=" . $row['id_producto'] . "'>";
                    echo "<i class='fas fa-user-edit w3-text-theme'></i>";
                    echo "</a></td>";
                    echo "<td style='width: 5%;'>";
                    echo "<a href='../productos/charge.php?id=" . $row['id_producto'] . "'>";
                    echo "<i class='fas fa-balance-scale w3-text-theme'></i>";
                    echo "</a></td>";
                    echo "<td style='width: 5%'>";
                    echo "<a href='../productos/show.php?id=" . $row['id_producto'] . "'>";
                    echo "<i class='w3-text-theme'>&#x270f;&#xfe0f;</i>";
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