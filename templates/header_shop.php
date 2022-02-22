 <?php 
 require '../config/functions.php';
 ?>
 <!DOCTYPE html>

 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title><?php echo $titulo ?> | CCSM</title>
     <link rel="icon" href="/club/img/ccms.ico" type="image/gif" sizes="16x16">
     <link rel="stylesheet" href="/club/css/w3.css">
     <link rel="stylesheet" href="/club/css/themes/w3-theme-<?php
    //  $servername = "localhost";
    //  $username = "root";
    //  $password = "";
    //  $dbname = "greenpower";
     // Create connection
    //  $conn = new mysqli($servername, $username, $password, $dbname);
     // Check connection
    //  if ($conn->connect_error) {
    //      die("Connection failed: " . $conn->connect_error);
    //     }
        $sql = "SELECT color, fuente, titulos FROM settings";
        $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo $row['color'];
    }
    // $conn->close();
    ?>.css">
    <link rel="stylesheet" href="/club/webfonts/stylesheet.css">
     <link rel="stylesheet" href="/club/fontawesome5/css/all.css">
     <link rel="stylesheet" href="/club/css/style.css">
     <link rel="stylesheet" href="/club/css/carrito.css">
 </head>
 <style>
     .panel {
         box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
     }

     h1,
     h2,
     h3,
     h4,
     h5,
     h6 {
         font-family: <?php
                        // $servername = "localhost";
                        // $username = "root";
                        // $password = "";
                        // $dbname = "greenpower";
                        // Create connection
                        // $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        // if ($conn->connect_error) {
                        //     die("Connection failed: " . $conn->connect_error);
                        // }
                        $sql = "SELECT *  FROM settings";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo $row['titulos'];
                        }
                        // $conn->close();
                        ?>;
     }
 </style>

 <body class="w3-theme-light font-<?php
                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $dbname = "greenpower";
                                    // Create connection
                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    $sql = "SELECT * FROM settings";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        echo $row['fuente'];
                                    }
                                    $conn->close();
                                    ?>">
     <div class="w3-container">