<?php
$titulo = "SOCIOS";
include '../templates/header.php';
// include '../templates/head_index.php';
?>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
        <thead>
            <tr class="w3-theme">
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>ID Card</th>
                <th>Fecha de nacimiento</th>
                <th colspan="2">Nacionalidad</th>
                <th>Rol</th>
                <th colspan="2">Genero</th>
                <th>Consumo mensual</th>
                <th>Saldo</th>
                <th>Editar</th>
                <th>Estado</th>
            </tr>
        </thead>
        <?php
        $socio = getSocios();
        foreach ($socio as $socio) :
        ?>
            <tr>
                <td style="width: 5%;"><?php echo $socio['id_socio'] ?></td>
                <td style="width: 5%"><?php echo $socio['nombre_socio'] ?></td>
                <td style="width: 5%"><?php echo $socio['apellidos_socio'] ?></td>
                <td style="width: 5%"><?php echo $socio['card_id_socio'] ?></td>
                <td style="width: 5%"><?php echo $socio['birth'] ?></td>
                <td style="width: 5%;"><?php echo $socio['pais'] ?></td>
                <td class="w3-xlarge" style="width: 2%"><?php echo $socio['bandera'] ?></td>
                <td style="width: 5%"><?php echo $socio['rol'] ?></td>
                <td style="width: 5%"><?php echo $socio['genero'] ?></td>
                <td class="w3-xlarge"  style="width: 2%"><?php echo $socio['signo'] ?></td>
                <td style="width: 5%"><?php echo $socio['consumo'] ?></td>
                <td style="width: 5%"><?php echo $socio['saldo'] ?></td>
                <td style="width: 5%">
                    <a href="update.php?id=<?php echo $socio['id_socio'] ?>">
                        <i class="fas fa-user-edit w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 5%">
                    <a href="show.php?id=<?php echo $socio['id_socio'] ?>">
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