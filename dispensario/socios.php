<?php
$titulo = "DISPENSARIO";
include "../templates/header.php"
?>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-64 w3-responsive">
    <table class="w3-table w3-striped w3-bordered w3-border w3-border-theme w3-centered">
        <thead>
            <tr class="w3-theme">
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>ID Card</th>
                <th>Fecha de nacimiento</th>
                <th>Nacionalidad</th>
                <th>Rol</th>
                <th>Genero</th>
                <th>Consumo mensual</th>
                <th>Saldo</th>
                <th>Editar</th>
                <th>Estado</th>
            </tr>
        </thead>
        <?php
        require '../config/functions.php';
        $socios = getSocios();
        foreach ($socios as $socios) :
        ?>
            <tr>
                <td style="width: 5%;"><?php echo $socios['id'] ?></td>
                <td style="width: 10%"><?php echo $socios['nombre'] ?></td>
                <td style="width: 10%"><?php echo $socios['apellidos'] ?></td>
                <td style="width: 10%"><?php echo $socios['dni'] ?></td>
                <td style="width: 10%"><?php echo $socios['birth'] ?></td>
                <td style="width: 10%"><?php echo $socios['pais'] ?></td>
                <td style="width: 10%"><?php echo $socios['rol'] ?></td>
                <td style="width: 10%"><?php echo $socios['genero'] ?></td>
                <td style="width: 5%"><?php echo $socios['consumo'] ?></td>
                <td style="width: 10%"><?php echo $socios['saldo'] ?></td>
                <td style="width: 10%">
                    <a href="update.php?id=<?php echo $socios['id'] ?>">
                        <i class="fas fa-user-edit w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 10%">
                    <a href="show.php?id=<?php echo $socios['id'] ?>">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php
include "../templates/footer.php";
?>