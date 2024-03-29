            <?php
                $titulo = 'Listado de socios';
                include '../templates/header.php';
                $socios = getSocios();
            ?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-container">
                    <div class="w3-display-container" style="height:60px;">
                    <h2 id="title" class="w3-display-left w3-text-theme"><b><?php echo $titulo ?></b></h2>
                    <a class="w3-display-right w3-button w3-blue w3-round-large w3-hover-green w3-margin-top " href="create.php"><i class="fas fa-plus-circle"></i> Nuevo registro</a>
                    </div>
                </div>
            </div>

    <div class="w3-container">
            <input type="text" id="search" onkeyup="searchTableByName()" placeholder="&#x1f50d;&#xfe0e; Search for names.." title="Type in a name" pattern="[a-zA-Z0-9]+" autofocus>

                    <table id="list" class="w3-table w3-striped w3-bordered w3-centered w3-responsive" style="color: #555">
                        <thead>
                            <tr class="w3-theme">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>ID Card</th>
                                <th>Fecha de nacimiento</th>
                                <th>Rol</th>
                                <th class="w3-center" colspan="2">Nacionalidad</th>
                                <th class="w3-center" colspan="2">Genero</th>
                                <th>Consumo mensual</th>
                                <th>Saldo</th>
                                <th>Activo</th>
                                <th>Editar</th>
                                <th class="w3-center"></th>
                                <th class="w3-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($socios as $socio) :
                            ?>
                            <tr>
                                <td style='width: 2%;'><?php echo $socio["id_socio"]?></td>
                                <td><?php echo $socio["nombre_socio"]?></td>
                                <td><?php echo $socio["apellidos_socio"]?></td>
                                <td><?php echo $socio["card_id_socio"]?></td>
                                <td><?php echo $socio["birth"]?></td>
                                <td><?php echo $socio["nombre_rol"]?></td>
                                <td><?php echo $socio["pais"]?></td>
                                <td><?php echo $socio["bandera"]?></td>
                                <td><?php echo $socio["nombre_genero"]?></td>
                                <td><?php echo $socio["signo"]?></td>
                                <td><?php echo $socio["consumo"]?></td>
                                <td><?php echo $socio["saldo"]?></td>
                                <td class='w3-center' style='width: 2%'>
                                    <input type='checkbox' class='activo' value='<?php echo $socio['activo']?>' disabled>
                                </td>
                                <td class='w3-center' style='width: 2%'>
                                    <a class="w3-text-green w3-hover-text-orange" href="update.php?id=<?php echo $socio['id_socio']?>">
                                        <i class='fas fa-pen w3-medium'></i>
                                    </a>
                                </td>
                                <td class='w3-center' style='width: 2%'>
                                    <a class='w3-text-green w3-hover-text-orange' href='charge.php?id="<?php echo $socio["id_socio"]?>"'>
                                        <i class='fas fa-balance-scale w3-medium'></i>
                                    </a>
                                </td>
                                <td class='w3-center' style='width: 2%'>
                                    <a class='w3-text-red w3-hover-text-orange' href='baja.php?id="<?php echo $socio["id_socio"]?>"' onclick='warningErase()'>
                                        <i class='fas fa-trash w3-medium'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <script>
                    captarCheckbox();
                </script>
                <?php
                    include '../templates/footer.php';
                ?>