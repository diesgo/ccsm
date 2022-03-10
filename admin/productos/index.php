                <?php
                $titulo = "Listado de productos";
                include '../templates/headerClean.php';
                $productos = getProductos();
                ?>
                <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
                    <thead>
                        <tr class="w3-theme">
                            <th>ID</th>
                            <th style="text-align: left;">Nombre</th>
                            <th>Servicio</th>
                            <th>Categoria</th>
                            <th>Variedad</th>
                            <th>PVC</th>
                            <th>PVP</th>
                            <th>Stock total</th>
                            <th>Editar</th>
                            <th>Recargar</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($productos as $producto) :
                        ?>
                        <tr>
                            <td style="width: 5%;"><?php echo $producto['id_producto'] ?></td>
                            <td style="width: 10%; text-align:left;"><?php echo $producto['nombre_producto'] ?></td>
                            <td style="width: 5%"><?php echo $producto['nombre_servicio'] ?></td>
                            <td style="width: 5%"><?php echo $producto['nombre_categoria'] ?></td>
                            <td style="width: 5%"><?php echo $producto['nombre_variedad'] ?></td>
                            <td style="width: 5%"><?php echo $producto['pc'] ?> €</td>
                            <td style="width: 5%"><?php echo $producto['pvp'] ?> €</td>
                            <td class="estado" style="width: 7%"><?php echo $producto['cantidad']?></td>
                            <td style="width: 5%">
                                <a href="update.php?id=<?php echo $producto['id_producto'] ?>">
                                    <i class="fas fa-user-edit w3-text-theme"></i>
                                </a>
                            </td>
                            <td style="width: 5%;">
                                <a href="charge.php?id=<?php echo $producto['id_producto'] ?>">
                                    <i class="fas fa-balance-scale w3-text-theme"></i>
                                </a>
                            </td>
                            <td style="width: 5%">
                                <a href="show.php?id=<?php echo $producto['id_producto'] ?>">
                                    <i class="fas fa-eye w3-text-theme"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <script>
                    estadoStock();
                    captarCheckbox();
                </script>
                <div class="w3-container w3-center w3-margin-top">
                    <a class="w3-button w3-theme w3-border w3-border-theme w3-round w3-hover-white w3-hover-text-theme w3-margin-top" href="create.php"><i class="fas fa-plus-circle"></i> Nuevo registro</a>
                </div>
                <?php
                include '../templates/footerClean.php';
                ?>