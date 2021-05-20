<?php
require_once "config.php";
date_default_timezone_set('Europe/Madrid');

$conex = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
$conn = mysqli_connect(DBHOST, DBUSER, DBPWD, DBNAME);

mysqli_set_charset($conex, 'utf8');


if (mysqli_connect_error()) {
    die('Error de Conexión (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}

// echo 'Éxito... ' . $conex->host_info . "\n";


?>