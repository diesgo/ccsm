<?php
$titulo = "RECEPCIÓN";
include '../templates/header_shop.php';
$socios = getSocios();
?>

    <!-- Captar chip -->

    <div class="w3-display-container">
        
        <form accept-charset="utf-8" action="#" method="post" name="socioActivo" id="socioActivo">

            <div id="pantalla" class="w3-display-middle w3-center">
                <script>
    var altura=screen.availHeight;
    document.getElementById("pantalla").style.height =  altura;
    console.log(altura);
    </script>
                <p>ID Socio</p>
                <input class="w3-border-theme w3-input" type="text" name="id" id="id" autofocus>
            </div>
        </form>
    </div>

<?php
include "../templates/footer.php";
?>