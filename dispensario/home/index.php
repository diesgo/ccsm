            <?php
            session_start();
            $connect = mysqli_connect("localhost", "root", "", "greenpower");
            if(isset($_POST["add_to_cart"])){
                if(isset($_SESSION["shopping_cart"])){
                    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                    if(!in_array($_GET["id"], $item_array_id)){
                        $count = count($_SESSION["shopping_cart"]);
                        $item_array = array('item_id' => $_GET["id"],'item_name' => $_POST["hidden_name"],'item_price' => $_POST["hidden_price"],'item_quantity' => $_POST["quantity"]);
                        $_SESSION["shopping_cart"][$count] = $item_array;
                    }else{
                        echo '<script>alert("El producto ya se encuentra agregado")</script>';
                    }
                }else{$item_array = array('item_id' => $_GET["id"], 'item_name' => $_POST["hidden_name"], 'item_price' => $_POST["hidden_price"], 'item_quantity' => $_POST["quantity"]);
                    $_SESSION["shopping_cart"][0] = $item_array;
                }
            }
            if(isset($_GET["action"])){
                if($_GET["action"] == "delete"){
                    foreach($_SESSION["shopping_cart"] as $keys => $values){
                        if($values["item_id"] == $_GET["id"]){
                            unset($_SESSION["shopping_cart"][$keys]);
                            // echo '<script>alert("Producto eliminado")</script>';
                            echo '<script>window.location="index.php"</script>';
                        }
                    }
                }
            }
            $titulo = "CCSM | Administración";
            include '../templates/header.php'
            ?>          
            <aside class="w3-sidebar w3-collapse" style="z-index:3; width:30%" id="mySidebar">
                <div>
                    <div style="clear:both"></div>
                    <h3>Detalle de la orden</h3>
                    <div class="table-responsive">
                        <table class="w3-table-all">
                            <tr class="w3-theme-l3">
                                <th width="40%">Descripción</th>
                                <th width="15%" class='w3-center'>Cantidad</th>
                                <th width="15%" class='w3-right-align'>Precio</th>
                                <th width="15%" class='w3-right-align'>Total</th>
                                <th width="15%"></th>
                            </tr>
                            <?php
                            if(!empty($_SESSION["shopping_cart"])){
                                $total = 0;
                                foreach($_SESSION["shopping_cart"] as $keys => $values){
                                    ?>
                                    <tr>
                                        <td><?php echo $values["item_name"]; ?></td>
                                        <td class='w3-center'><?php echo $values["item_quantity"]; ?></td>
                                        <td class='w3-right-align'>€ <?php echo $values["item_price"]; ?></td>
                                        <td class='w3-right-align'>€ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                                        <td class="w3-center"><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="w3-text-red"><i class="fas fa-times"></i></span></a></td>
                                    </tr>
                                    <?php
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                                }
                                ?>
                                <tr>
                                    <td colspan="3" align="right">Total</td>
                                    <td class="w3-right-align">€ <?php echo number_format($total, 2); ?></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <input type="submit" value="Guardar">
                    </div>
                </div>
            </aside>

            <div class="w3-main" style="margin-left:30%;">

                <div class="w3-bar">
                    <?php
                    $categorias = getCategorias();
                    foreach ($categorias as $categoria) :
                    ?>
                    <button class="w3-bar-item w3-button w3-theme w3-padding-large w3-round-large w3-margin-right w3-xlarge" onclick="openCity('<?php echo $categoria['nombre_categoria']?>')"><?php echo $categoria['nombre_categoria']?></button>
                    <?php endforeach; ?>
                </div>

                <?php
                $categorias = getCategorias();
                if(mysqli_num_rows($categorias) > 0){
                    while($row = mysqli_fetch_array($categorias)){?>
                        <div id="<?php echo $row['nombre_categoria']?>" class="w3-container w3-display-container city" style="display:none">
                            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-theme  w3-hover-red w3-xlarge w3-display-topright"><i class="fas fa-times"></i></span>
                            <?php
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            $sql = "SELECT * FROM productos INNER JOIN servicios ON id_servicio = servicio_id INNER JOIN variedades ON id_variedad = variedad_id WHERE categoria_id='" . $row['id_categoria'] . "'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $cantidad = $row["cantidad"] + $row['dispensario'];?>
                                    <div class="w3-col l3 m3">
                                        <form class="w3-padding" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?action=add&id=<?php echo $row["id_producto"]; ?>">
                                            <div class="w3-card w3-padding">
                                                <h4 class="w3-text-blue w3-center"><?php echo $row["nombre_producto"]; ?></h4>
                                                <h4 class="w3-text-red w3-center">€ <?php echo $row["pvp"]; ?></h4>
                                                <div class="w3-row">
                                                    <div class="w3-col l4 m4 w3-padding">
                                                        <input id="quantity" type="text" name="quantity" class="w3-input w3-border" placeholder="gr." value="1" />
                                                    </div>
                                                    <div class="w3-col l4 m4 w3-padding">
                                                        <input id="price" type="text" name="price" class="w3-input w3-border" placeholder="€" value=<?php echo $row['pvp'] ?> />
                                                    </div>
                                                    <div class="w3-col l4 m4 w3-padding">
                                                        <input id="gift" type="text" name="gift" class="w3-input w3-border" placeholder="&#x1f381;" value="" />
                                                    </div>
                                                </div>
                                                <p class='w3-center'><input type="submit" name="add_to_cart" class="w3-round-large w3-btn w3-green " value="Agregar al carro" /></p> 
                                                <input type="hidden" name="hidden_name" value="<?php echo $row["nombre_producto"]; ?>" />
                                                <input type="hidden" name="hidden_price" value="<?php echo $row["pvp"]; ?>" />
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "No se han encontrado productos de esta categoría.";
                            }
                            mysqli_close($conn);
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>

            

            

            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  -->
            <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
            <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->

            
            
            <?php
                include '../templates/footer.php';
            ?>