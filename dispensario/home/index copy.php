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
                            echo '<script>alert("Producto eliminado")</script>';
                            echo '<script>window.location="index.php"</script>';
                        }
                    }
                }
            }
            $titulo = "CCSM | Administración";
            include '../templates/header.php';
            ?>

            <div class="w3-bar w3-black">
                <?php
                $query = "SELECT * FROM categorias ORDER BY id_categoria ASC";
                $result = mysqli_query($connect, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){?>
                        <button class="w3-bar-item w3-button w3-padding-16" onclick="openCity('<?php echo $row['nombre_categoria']?>')"><?php echo $row['nombre_categoria']?></button>
                        <?php
                    }
                }
                ?>
            </div>

            <?php
            $query = "SELECT * FROM categorias ORDER BY id_categoria ASC";
            $result = mysqli_query($connect, $query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){?>
                <div id="<?php echo $row['nombre_categoria']?>" class="w3-container w3-display-container city">
                    <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                    <h2><?php echo $row['nombre_categoria']?></h2>
                    <p><?php echo $row['nombre_categoria']?> is the capital city of <?php echo $row['nombre_categoria']?>.</p>


                    <?php
                    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                    $sql = "SELECT * FROM productos WHERE categoria_id='" . $row['id_categoria'] . "'";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        while($rowe = mysqli_fetch_array($result)){?>
                        <div class="w3-col l4 m4">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?action=add&id=<?php echo $rowe["id_producto"]; ?>">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <h4 class="w3-text-blue w3-center"><?php echo $rowe["nombre_producto"]; ?></h4>
                                        <h4 class="w3-text-red w3-center">$ <?php echo $rowe["pvp"]; ?></h4>
                                        <div class="w3-row">
                                            <div class="w3-col l4 m4">
                                                <input type="text" name="quantity" class="form-control " placeholder="gr." value="" />
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="text" name="price" class="form-control" placeholder="€" value=<?php echo $rowe['pvp'] ?> onkeyup="peso();"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="text" name="gift" class="form-control" placeholder="" value="1" />
                                            </div>
                                        </div>
                                        <p class='text-center'><input type="submit" name="add_to_cart" class="w3-btn w3-green " value="Agregar al carro" /></p> 
                                        <input type="hidden" name="hidden_name" value="<?php echo $rowe["nombre_producto"]; ?>" />
                                        <input type="hidden" name="hidden_price" value="<?php echo $rowe["pvp"]; ?>" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                        }
                    }?>
                </div>
                <?php
                echo $row['id_categoria'];
            }
        }
        ?>

            <script>
            function openCity(cityName) {
              var i;
              var x = document.getElementsByClassName("city");
              for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";  
              }
              document.getElementById(cityName).style.display = "block";  
            }
            </script>

                <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
                <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->

            <body>
                <div class="w3-container" style="width:800px;">
                    <h3 align="center">Categoria: <?php echo "" ?></h3>
                    <?php
                        $query = "SELECT * FROM productos ORDER BY id_producto ASC";
                        $result = mysqli_query($connect, $query);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                ?>
                                <div class="w3-col l4 m4">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?action=add&id=<?php echo $row["id_producto"]; ?>">
                                        <div class="thumbnail">
                                            <div class="caption">
                                                <h4 class="w3-text-blue w3-center"><?php echo $row["nombre_producto"]; ?></h4>
                                                <h4 class="w3-text-red w3-center">$ <?php echo $row["pvp"]; ?></h4>
                                                <div class="w3-row">
                                                    <div class="w3-col l4 m4">
                                                        <input type="text" name="quantity" class="form-control " placeholder="gr." value="" />
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="price" class="form-control" placeholder="€" value=<?php echo $row['pvp'] ?> onkeyup="peso();"/>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="gift" class="form-control" placeholder="" value="1" />
                                                    </div>
                                                </div>
                                                <p class='text-center'><input type="submit" name="add_to_cart" class="w3-btn w3-green " value="Agregar al carro" /></p> 
                                                <input type="hidden" name="hidden_name" value="<?php echo $row["nombre_producto"]; ?>" />
                                                <input type="hidden" name="hidden_price" value="<?php echo $row["pvp"]; ?>" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <script>
                        // function peso(){
                        //     var q = document.getElementsByName('quantity');
                        //     var p = document.getElementsByName('price').innerHTML;
                        //     var v = document.getElementsByName('hidden_price');
                        //     var ti= q.length;
                        //     console.log(ti);
                        //     for (let b = 0; b < q.length; b++) {
                        //         console.log(p[b]);

                        //     }
                        // }
                    </script>
                    <div style="clear:both"></div>
                        <h3>Detalle de la orden</h3>
                        <div class="table-responsive">
                            <table class="w3-table-all table-bordered">
                                <tr>
                                    <th width="40%">Descripción</th>
                                    <th width="10%" class='text-center'>Cantidad</th>
                                    <th width="20%" class='text-right'>Precio</th>
                                    <th width="15%" class='text-right'>Total</th>
                                    <th width="5%"></th>
                                </tr>
                                <?php
                                    if(!empty($_SESSION["shopping_cart"])){
                                        $total = 0;
                                        foreach($_SESSION["shopping_cart"] as $keys => $values){
                                ?>
                                <tr>
                                    <td><?php echo $values["item_name"]; ?></td>
                                    <td class='text-center'><?php echo $values["item_quantity"]; ?></td>
                                    <td class='text-right'>$ <?php echo $values["item_price"]; ?></td>
                                    <td class='text-right'>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                                    <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="w3-text-red">Eliminar</span></a></td>
                                </tr>
                                    <?php
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3" align="right">Total</td>
                                            <td align="right">$ <?php echo number_format($total, 2); ?></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
            <?php
                include '../templates/footer.php';
            ?>