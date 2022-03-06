<?php
define('USER', 'DP028US00001');
define('PASSWORD', 'Dimapema73?');
define('HOST', 'localhost');
define('DATABASE', 'greenpower');
 
try {
    $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>