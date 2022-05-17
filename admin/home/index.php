            <?php
            $titulo = "CCSM | Administración";
            include '../templates/header.php';
            ?>

            <!-- Header -->

            <div class="w3-container w3-padding-32">
                <div class="w3-content">
                    <h2 id="title" class="w3-center w3-text-theme"><b><?php echo $titulo ?></b></h2>
                </div>
            </div>
            <div class="w3-row w3-padding-32">
                <div class="w3-container">
                    <h2 class="w3-text-theme">Accesos rápidos</h2>
                </div>
                <div class="w3-col l3 m3 w3-padding">
                    <form accept-charset="utf-8" action="../productos/charge.php?" method="get" name="charge_form" id="charge_form">
                        <label for="id  " class="w3-text-theme w3-xlarge">Recargar producto</label>
                        <select name="id" class="w3-select w3-white w3-border w3-border-theme-l4 w3-round" required>
                            <option value="">Selecciona...</option>
                            <?php
                                $productos = getProductos();
                                foreach ($productos as $producto) :
                            ?>
                            <option value=<?php echo $producto['id_producto']; ?>><?php echo $producto['nombre_producto'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="w3-col w3-margin-top">
                            <input type="submit" value="Recargar" name="charge" class="w3-btn w3-theme w3-round-large w3-block w3-hover-orange">
                        </div>
                    </form>
                </div>
                <div class="w3-col l3 m3 w3-padding w3-center">
                    <a class="w3-btn w3-theme w3-border w3-border-theme w3-round-xxlarge w3-padding-large" href="../productos/create.php">Nuevo artículo</a>
                </div>
                <div class="w3-col l3 m3 w3-padding w3-center">
                    <a class="w3-btn w3-theme w3-border w3-border-theme w3-round-xxlarge w3-padding-large" href="../socios/create.php">Nuevo socio</a>
                </div>    
            </div>
    
            <div class="w3-row-padding w3-margin-bottom">

                <div class="w3-quarter">
                    <div class="w3-container w3-red w3-padding-16">
                        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                        <div class="w3-right">
                            <?php
                                $socios = getNumSocios();
                                if (mysqli_num_rows($socios) > 0) {
                                    echo "<h3>" . mysqli_num_rows($socios) . "</h3>";
                                } else {
                                    echo "0 results";
                                }
                            ?>
                        </div>
                        <div class="w3-clear"></div>
                        <h4>Socios</h4>
                    </div>
                </div>

                <div class="w3-quarter">
                    <div class="w3-container w3-theme w3-padding-16">
                        <div class="w3-left"><i class="fas fa-boxes w3-xxxlarge"></i></div>
                        <div class="w3-right">
                            <?php
                                $productos = getNumProducts();
                                if (mysqli_num_rows($productos) > 0) {
                                    // output data of each row
                                    echo "<h3>" . mysqli_num_rows($productos) . "</h3>";
                                } else {
                                    echo "0 results";
                                }
                            ?>
                        </div>
                        <div class="w3-clear"></div>
                        <h4>Productos</h4>
                    </div>
                </div>

                <div class="w3-quarter">
                    <div class="w3-container w3-orange w3-text-white w3-padding-16">
                        <div class="w3-left"><i class="fas fa-layer-group w3-xxxlarge"></i></div>
                        <div class="w3-right">
                            <?php
                                $categorias = getCategorias();
                                if (mysqli_num_rows($categorias) > 0) {
                                    // output data of each row
                                    echo "<h3>" . mysqli_num_rows($categorias) . "</h3>";
                                } else {
                                    echo "0 results";
                                }
                            ?>
                        </div>
                        <div class="w3-clear"></div>
                        <h4>Categorias</h4>
                    </div>
                </div>
 
                <div class="w3-quarter">
                    <div class="w3-container w3-teal w3-padding-16">
                        <div class="w3-left"><i class="fas fa-user-plus w3-xxxlarge"></i></div>
                        <div class="w3-right">
                            <h3>0</h3>
                        </div>
                        <div class="w3-clear"></div>
                        <h4>New socios</h4>
                    </div>
                </div>

            </div>

            <!-- End page content -->

            <div class="w3-container w3-padding-64 w3-responsive" style="min-height: 616px;">
                <!-- Header -->

                <div class="w3-panel">
                    <div class="w3-row-padding" style="margin:0 -16px">

                        <div class="w3-half">
                            <div class="w3-container">
                                <h5>Procedéncia de los socios</h5>
                                <table class="w3-table-all w3-striped w3-border w3-border-theme w3-medium" style="max-height: 500px; overflow:auto; color: #555">
                                    <thead>
                                        <tr class="w3-theme">
                                            <th>Pais</th>
                                            <th class='w3-center'>Bandera</th>
                                            <th class='w3-center'>Porcentaje</th>
                                        </tr>
                                    <thead>
                                    <tbody>
                                        <?php
                                            $paises=getPaisesSocios();
                                            if (mysqli_num_rows($paises) > 0) {
                                                // output data of each row
                                                while ($row = mysqli_fetch_assoc($paises)) {
                                                     echo "<tr>";
                                                        echo "<td> " . $row["pais"] . "</td>";
                                                        echo "<td class='w3-center'> " . $row["bandera"] . "</td>";
                                                        echo "<td class='w3-center'> " . mysqli_num_rows($paises) . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "No se han encontrado registros.";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                            <div class="w3-half">
                            <h5>Recargas</h5>
                            <table id="grid" class="w3-table w3-striped w3-bordered w3-centered w3-responsive" style="max-height: 500px; overflow:auto; color: #555">
                                <thead>
                                    <tr class="w3-theme">
                                        <th>ID</th>
                                        <th>Origen</th>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th>Cantidad</th>
                                        <th>Precio de compra</th>
                                        <th>Destino</th>
                                        <th>Cantidad</th>
                                        <th>Stock total</th>
                                    </tr>
                                </thead>
                                <?php
                                    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                                    $sql = "SELECT * FROM movimientos_stock
                                    -- INNER JOIN productos ON id_producto = producto_id
                                    -- INNER JOIN proveedores ON id_proveedor = proveedor _id
                                    INNER JOIN destinos ON id_destino = destino_id";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                                echo "<td> " . $row["id_movimiento"] . "</td>";
                                                echo "<td> " . $row["proveedor_id"] . "</td>";
                                                echo "<td> " . $row["producto_id"] . "</td>";
                                                echo "<td> " . $row["stock_antes"] . "</td>";
                                                echo "<td> " . $row["recarga"] . "</td>";
                                                echo "<td> " . $row["pc"] . "</td>";
                                                echo "<td> " . $row["nombre_destino"] . "</td>";
                                                echo "<td> " . $row["retirada"] . "</td>";
                                                echo "<td> " . $row["stock_despues"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "No se han encontrado registros.";
                                    }
                                    mysqli_close($conn);
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <div class="w3-container w3-dark-grey w3-padding-32">
                    <div class="w3-row">
                        <div class="w3-container w3-third">
                            <h5 class="w3-bottombar w3-border-green">Demographic</h5>
                            <p>Language</p>
                            <p>Country</p>
                            <p>City</p>
                        </div>
                        <div class="w3-container w3-third">
                            <h5 class="w3-bottombar w3-border-red">System</h5>
                            <p>Browser</p>
                            <p>OS</p>
                            <p>More</p>
                        </div>
                        <div class="w3-container w3-third">
                            <h5 class="w3-bottombar w3-border-orange">Target</h5>
                            <p>Users</p>
                            <p>Active</p>
                            <p>Geo</p>
                            <p>Interests</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                include '../templates/footer.php';
            ?>