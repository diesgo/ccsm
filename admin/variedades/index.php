<?php
$titulo = 'VARIEDAES';
include '../templates/header.php';
include '../templates/head_index.php';
?>

<!-- !PAGE CONTENT! -->

<div class="w3-container w3-padding-32 w3-responsive" style="min-height: 636px;">
    <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
        <thead>
            <tr class="w3-theme">
                <th>ID</th>
                <th>Variedad</th>
                <th>Editar</th>
                <th>Ver</th>
            </tr>
        </thead>
        <?php
        require_once '../../config/functions.php';
        $variedades = getVariedades();
        foreach ($variedades as $variedad) :
        ?>
            <tr>
                <td style="width: 5%;"><?php echo $variedad['id'] ?></td>
                <td style="width: 10%"><?php echo $variedad['nombre'] ?></td>
                <td style="width: 10%">
                    <a href="update.php?id=<?php echo $variedad['id'] ?>">
                        <i class="fas fa-pen w3-text-theme"></i>
                    </a>
                </td>
                <td style="width: 10%">
                    <a href="show.php?id=<?php echo $variedad['id'] ?>">
                        <i class="fas fa-eye w3-text-theme"></i>
                    </a>
                </td>
            <?php endforeach; ?>
    </table>
</div>

<?php
include '../templates/footer.php';
?>