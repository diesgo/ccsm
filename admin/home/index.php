<?php
$titulo = "CCSM | Administración";
include '../templates/header.php';
?>

        <!-- !PAGE CONTENT! -->
    
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter">
                <div class="w3-container w3-red w3-padding-16">
                    <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>52</h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Messages</h4>
                </div>
            </div>
            <div class="w3-quarter">
                <div class="w3-container w3-theme w3-padding-16">
                    <div class="w3-left"><i class="fas fa-euro-sign w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>99</h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Cash</h4>
                </div>
            </div>
            <div class="w3-quarter">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>11</h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Socios</h4>
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
        
        <div class="w3-container">
            <h5><b>General Stats</b></h5>
            <p>New socio</p>
            <div class="w3-grey">
                <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
            </div>
    
            <p>Total sales</p>
            <div class="w3-grey">
                <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
            </div>
    
            <p>Total gr</p>
            <div class="w3-grey">
                <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
            </div>
        </div>
        <hr>

        <!-- End page content -->







<div class="w3-container w3-padding-32 w3-theme-l4">
    <div class="w3-half">
        <h2 class="w3-text-theme"><b><i class="fa fa-dashboard"></i>Administración</b></h2>
    </div>
    <div class="w3-half">

    </div>
</div>
<div class="w3-container w3-padding-64 w3-responsive" style="min-height: 616px;">
    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5 class="w3-text-theme"><b><i class="fas fa-tachometer-alt"></i> Panel de control</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-quarter">
            <div class="w3-container w3-theme w3-text-white w3-padding-16 w3-card-4">
                <div class="w3-left"><i class="fa fa-users w3-xlarge"></i></div>
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
            <div class="w3-container w3-theme-dark w3-padding-16 w3-card-4">
                <div class="w3-left"><i class="fas fa-boxes w3-xlarge"></i></div>
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
            <div class="w3-container w3-blue w3-padding-16 w3-card-4">
                <div class="w3-left"><i class="fas fa-layer-group w3-xlarge"></i></div>
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
            <div class="w3-container w3-teal w3-padding-16 w3-card-4">
                <div class="w3-left"><i class="fa fa-share-alt w3-xlarge"></i></div>
                <div class="w3-right">
                    <h3>23</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Shares</h4>
            </div>
        </div>

    </div>

    <div class="w3-panel">
        <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-half">
                <div class="w3-container">
                    <h5>Procedéncia de los socios</h5>
                    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                        <thead>
                            <tr class="w3-theme"><table class="w3-table-all w3-striped w3-border w3-border-theme w3-medium">
                            <thead>
                                <tr class="w3-theme">
                                    <th>Pais</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>
            <div class="w3-half">
                <h5>Recargas</h5>
                <table class="w3-table-all w3-striped w3-border w3-border-theme w3-centered">
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
            $sql = "SELECT * FROM movimientos_stock";
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
                    echo "<td> " . $row["destino_id"] . "</td>";
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
    <div class="w3-container">
        <h5>General Stats</h5>
        <p>New Visitors</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
        </div>

        <p>New Users</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
        </div>

        <p>Bounce Rate</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
        </div>
    </div>
    <hr>


    <hr>
    <div class="w3-container">
        <h5>Recent Users</h5>
        <ul class="w3-ul w3-card-4 w3-white">
            <li class="w3-padding-16">
                <img src="../../img/s/3.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                <span class="w3-xlarge">Mike</span><br>
            </li>
            <li class="w3-padding-16">
                <img src="../../img/s/4.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                <span class="w3-xlarge">Jill</span><br>
            </li>
            <li class="w3-padding-16">
                <img src="../../img/s/5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                <span class="w3-xlarge">Jane</span><br>
            </li>
        </ul>
    </div>
    <hr>

    <div class="w3-container">
        <h5>Recent Comments</h5>
        <div class="w3-row">
            <div class="w3-col m2 text-center">
                <img class="w3-circle" src="../../img/s/2.png" style="width:96px;height:96px">
            </div>
            <div class="w3-col m10 w3-container">
                <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
                <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
            </div>
        </div>

        <div class="w3-row">
            <div class="w3-col m2 text-center">
                <img class="w3-circle" src="../../img/s/0.png" style="width:96px;height:96px">
            </div>
            <div class="w3-col m10 w3-container">
                <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
                <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
            </div>
        </div>
    </div>
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