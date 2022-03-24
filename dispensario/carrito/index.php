<?php
$titulo ="Dispensario";
include '../templates/header.php';
?>

    <div class="w3-container">
    <h2>Closable Tabs</h2>
    <p>To close a tab, add onclick="this.parentElement.style.display='none'" to an element inside the tab container.</p>
    <p><strong>Tip:</strong> The w3-button class can be used to style the close button (x):</p>
    </div>

    <div class="w3-bar w3-black">
         <?php
            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
            $sql = "SELECT * FROM categorias";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {?>
                    <button class='w3-bar-item w3-button' onclick="openCity('<?php echo $row['nombre_categoria']?>')"><?php echo $row['nombre_categoria']?></button>
                    <?php
                    }
                } else {
                    echo "No se han encontrado registros.";
                }
                mysqli_close($conn);
        ?>

    </div>
        <?php
            $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
            $sql = 'SELECT * FROM productos WHERE categoria_id =' . $row['id_categoria'];
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {?>
                <div id="<?php echo $row['nombre_categoria']?>" class="w3-container w3-display-container city" style="display:none">
                    <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                    <?php echo $row['nombre_categoria'];
                ?>
                </div>
                    
                    <?php
                    }
                } else {
                    echo "No se han encontrado registros.";
                }
                mysqli_close($conn);
        ?>
        
    

    <div id="Hash" class="w3-container w3-display-container city" style="display:none">
    <span onclick="this.parentElement.style.display='none'"
    class="w3-button w3-large w3-display-topright">&times;</span>
    <h2>Paris</h2>
    <p>Paris is the capital of France.</p> 
    </div>

    <div id="Tokyo" class="w3-container w3-display-container city" style="display:none">
    <span onclick="this.parentElement.style.display='none'"
    class="w3-button w3-large w3-display-topright">&times;</span>
    <h2>Tokyo</h2>
    <p>Tokyo is the capital of Japan.</p>
    </div>

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

<?php
include '../templates/footer.php';