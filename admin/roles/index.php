<?php
$titulo = 'ROLES';
include '../templates/header.php';
?>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 636px;">
    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
        <thead>
            <tr class="w3-theme">
                <th>ID</th>
                <th>Rol</th>
                <th>Descripción</th>
                <th>Editar</th>
                <th>Ver</th>
            </tr>
        </thead>
        <?php
        $roles = getRoles();
        foreach ($roles as $rol) :
        ?>
            <tr>
                <td style="width: 5%;"><?php echo $rol['id_rol'] ?></td>
                <td style="width: 10%"><?php echo $rol['rol'] ?></td>
                <td style="width: 15%"><?php echo $rol['descripcion'] ?></td>
                <td style="width: 10%">
                    <a href="update.php?id=<?php echo $rol['id_rol'] ?>">
                        <i class="fas fa-pen w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 10%">
                    <a href="show.php?id=<?php echo $rol['id_rol'] ?>">
                        <i class="fas fa-eye w3-text-theme"></i>
                    </a>
                </td>
            <?php endforeach; ?>
    </table>
</div>

<?php
include '../templates/footer.php';
?>