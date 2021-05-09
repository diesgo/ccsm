<?php include '../templates/header.php' ?>
<div class="w3-container w3-center w3-margin-top w3-padding">
    <div class="w3-twothird w3-padding" id="productoContenedor">
        <div class="w3-container w3-border w3-border-theme w3-round w3-padding">
            <div class="producto" data-idproducto="Refresco" data-img="img/Refresco.jpg" data-des="Coca-Cola es una bebida efervescente sabor cola" data-precio="7" data-cantidad="0">
                <div class="w3-container w3-border w3-border-theme w3-round">
                    <h3>Refresco</h3>
                    <p>$7</p>
                    <p>Compar</p>
                </div>
            </div>
            <div class="producto" data-idproducto="Doritos" data-img="img/Doritos.jpg" data-des="Tortilla chip elaborada por la multinacional Frito Lay" data-precio="12" data-cantidad="0">
                <div class="w3-container w3-border w3-border-theme w3-round">
                    <h3>Doritos</h3>
                    <p>$12</p>
                    <p>Compar</p>
                </div>
            </div>
            <div class="producto" data-idproducto="Sabritas" data-img="img/Sabritas.jpg" data-des="Papas fritas con sal" data-precio="15" data-cantidad="0">
                <div class="w3-container w3-border w3-border-theme w3-round">
                    <h3>Sabritas</h3>
                    <p>$15</p>
                    <p>Compar</p>
                </div>
            </div>
            <div class="producto" data-idproducto="CarlosV" data-img="img/CarlosV.jpg" data-des="Barra de chocolate semi-amargo" data-precio="9" data-cantidad="0">
                <div class="w3-container w3-border w3-border-theme w3-round">
                    <h3>Carlos V</h3>
                    <p>$9</p>
                    <p>Compar</p>
                </div>
            </div>
            <div class="producto" data-idproducto="Chokis" data-img="img/Chokis.jpg" data-des="Galletas con chispas de chocolate" data-precio="12" data-cantidad="0">
                <div class="w3-container w3-border w3-border-theme w3-round">
                    <h3>Chokis</h3>
                    <p>$12</p>
                    <p>Compar</p>
                </div>
            </div>
            <div class="producto" data-idproducto="DonJulio" data-img="img/Donjulio.png" data-des="Tequila Añejo Reposado" data-precio="500" data-cantidad="0">
                <div class="w3-container w3-border w3-border-theme w3-round">
                    <h3>Don Julio</h3>
                    <p>$500</p>
                    <p">Compar</p>
                </div>
            </div>
            <div class="producto" data-idproducto="M&ms" data-img="img/M&m.jpg" data-des="Chocolate confitado" data-precio="17" data-cantidad="0">
                <div class="w3-container w3-border w3-border-theme w3-round">
                    <h3>M&M´S</h3>
                    <p>$17</p>
                    <p  >Compar</p>
                </div>
            </div>
        </div>
    </div>
    <div class="w3-third w3-padding">
        <div class="w3-container w3-border w3-border-theme w3-round">
            <div id="carritoDeCompras"> </div>
            <h4 id=precioTotal>A Pagar: $0</h4>
        </div>
    </div>
</div>
<script src="../js/carrito.js"></script>

<?php include '../templates/footer.php'  ?>