<?php
require "config.php";
// Create connection
$conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CCSM</title>
    <link rel="icon" href="img/ccms.ico" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/themes/w3-theme-<?php
                                                                                                            $sql = "SELECT color FROM settings";
                                                                                                            $result = $conn->query($sql);
                                                                                                            while ($row = $result->fetch_assoc()) {
                                                                                                                echo $row['color'];
                                                                                                            }?>.css">
    <link rel="stylesheet" href="webfonts/stylesheet.css">
    <link rel="stylesheet" href="fontawesome5/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/carrito.css">
</head>
<style>

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: <?php
                        $sql = "SELECT *  FROM settings";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo $row['titulos'];
                        }
                        ?>;
    }
</style>

<body class="w3-theme-light font-<?php
                                    while ($row = $result->fetch_assoc()) {
                                        echo $row['fuente'];
                                    }
                                    $conn->close();
                                    ?>">
        <style>
            body {
                background-color: #eff1f2;
                color: #555;
                direction: ltr;
                margin: 0;
            }

            #login {
                min-height: 100%;
                padding-bottom: 45px;
            }

            #login-panel {
                margin: 0 auto;
                width: 350px;
            }

            #login-header {
                color: #6d6d6d;
                margin-bottom: 30px;
                padding-top: 40px;
            }

            .flip-container {
                height: 420px;
                margin-top: 80px;
                perspective: 1000px;
                transform-style: preserve-3d;
            }

            .back,
            .front {
                backface-visibility: hidden;
                left: 0;
                padding: 40px;
                position: absolute;
                top: 0;
                transform-style: preserve-3d;
                transition: .6s;
                width: 100%;
            }

            #shop-img {
                left: 0;
                top: 215px;
                margin: 0 auto;
                position: absolute;
                right: 0;
                width: 90px;
                z-index: 1;
            }
        </style>
        <div id="login">
            <div id="content">
                <div id="login-panel">

                    <div id="shop-img"><img class="w3-image" src="img/ccms_logo.png" alt="Club Name" /></div>

                    <div class="flip-container w3-margin-bottom" style="margin-top: 265px;">

                        <div class="front panel w3-white">
                            <h4 id="shop_name" class="w3-center">pre-alfa 1.0</h4>
                            <form id="login_form" method="post" action="select.php">
                                <div class="w3-margin-bottom w3-row">
                                    <label for="user">Nombre de usuario</label>
                                    <input name="user" type="text" id="user" class="w3-block" autofocus="autofocus" tabindex="1" placeholder="&#128100 Usuario" />
                                </div>
                                <div class="w3-margin-bottom">
                                    <label for="passwod">Contraseña</label>
                                    <input name="password" type="password" id="password" class="w3-block" tabindex="2" placeholder="&#128273 Contraseña" /><br>
                                    <label class="w3-right" for="passwd" style="position: relative; top: -15px;">Show Password
                                        <input type="checkbox" name="passwd" id="passwd" onclick="showPassword()">
                                    </label>
                                    <script>
                                        function showPassword() {
                                            var x = document.getElementById("password");
                                            if (x.type === "password") {
                                                x.type = "text";
                                            } else {
                                                x.type = "password";
                                            }
                                        }
                                    </script>
                                </div>
                                <div class="w3-margin-bottom">
                                    <button id="submit_login" type="submit" class="w3-button w3-theme w3-block w3-round w3-hover-theme" name="submitLogin" tabindex="4">
                                        <span class="font-densia">Iniciar sesión</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div id="login-footer">
                        <p class="w3-center w3-margin-bottom">&copy; <span class="font-sweet-leaf">CCSM</span>&#8482; 2020-2021 - All rights reserved</p>
                        <p class="w3-center" style="letter-spacing: 5px;">
                            <a class="w3-xlarge w3-text-blue fab fa-twitter" href="#" title="Twitter"></a>
                            <a class="w3-xlarge w3-text-indigo fab fa-facebook" href="#" title="Facebook"></a>
                            <a class="w3-xlarge w3-text-darkgrey fab fa-github" href="#" title="Github"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function tipoDeUsuario() {
                var kindOfUser = document.getElementById('rol').selectedIndex;
                switch (kindOfUser) {
                    case 1:
                        document.getElementById("login_form").setAttribute("action", "select.php")
                        break;
                    case 2:
                        document.getElementById("login_form").setAttribute("action", "dispensario/index.php")
                        break;
                    default:
                        break;
                }
            }
        </script>
</body>

</html>