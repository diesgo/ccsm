                    <?php
                        $titulo = 'Categorias';
                        include '../templates/header.php';
                    ?>
                    <div class="w3-container">
                        <div class="w3-row-padding">
                            <?php
                            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            $sql = "SELECT * FROM categorias";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<div class='w3-col l3 m3 s6 w3-padding-small'>";
                                        echo "<a class='w3-text-green w3-hover-text-orange' href='../carrito/index.php?id=" . $row['id_categoria'] . "'>";
                                            echo "<div class='w3-container w3-border w3-border-theme w3-round'>";
                                                echo "<h3 class='w3-text-theme'>" . $row["nombre_categoria"] . "</h3>";
                                            echo "</div>";
                                        echo "</a>";
                                    echo "</div>";
                                }
                            } else {
                                echo "No se han encontrado registros.";
                            }
                            mysqli_close($conn);
                            ?>
                        </div>
                    </div>
                <?php
                    include '../templates/footerIndex.php';
                ?>