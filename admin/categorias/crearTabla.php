 <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "greenpower";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Fallo en la conexión: " . $conn->connect_error);
    }

    // sql to create table
    $sql = "CREATE TABLE weed (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
weed_nombre VARCHAR(30) NOT NULL,
weed_variedad VARCHAR(30) NOT NULL,
weed_precio_compra VARCHAR(10),
weed_precio_venta VARCHAR(10),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

    if ($conn->query($sql) === TRUE) {
        echo "Se ha creado la tabla weed";
    } else {
        echo "Error al crear la tabla: " . $conn->error;
    }

    $conn->close();
    ?> 