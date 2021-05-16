<?php include '../templates/header_shop.php' ?>
<script>
    window.onload = function() {
        // Variables
        const baseDeDatos = [{
                id: 1,
                nombre: 'Patata',
                precio: 1,
                imagen: '0.jpg'
            },
            {
                id: 2,
                nombre: 'Cebolla',
                precio: 1.2,
                imagen: '1.jpg'
            },
            {
                id: 3,
                nombre: 'Calabacin',
                precio: 2.1,
                imagen: '2.jpg'
            },
            {
                id: 4,
                nombre: 'Fresas',
                precio: 0.6,
                imagen: '3.jpg'
            }

        ];

        let carrito = [];
        let total = 0;
        const DOMitems = document.querySelector('#items');
        const DOMcarrito = document.querySelector('#carrito');
        const DOMtotal = document.querySelector('#total');
        const DOMbotonVaciar = document.querySelector('#boton-vaciar');

        // Funciones

        /**
         * Dibuja todos los productos a partir de la base de datos. No confundir con el carrito
         */
        function renderizarProductos() {
            baseDeDatos.forEach((info) => {
                // Estructura
                const miNodo = document.createElement('div');
                miNodo.classList.add('w3-col', 'l2', 'm2');
                // Body
                const miNodoCardBody = document.createElement('div');
                miNodoCardBody.classList.add('w3-padding');
                // Titulo
                const miNodoTitle = document.createElement('h5');
                miNodoTitle.classList.add('card-title');
                miNodoTitle.textContent = info.nombre;
                // Imagen
                const miNodoImagen = document.createElement('img');
                miNodoImagen.classList.add('w3-image');
                miNodoImagen.setAttribute('src', '../img/p/' + info.imagen);
                // Precio
                const miNodoPrecio = document.createElement('p');
                miNodoPrecio.classList.add('card-text');
                miNodoPrecio.textContent = info.precio + '€';
                // Boton 
                const miNodoBoton = document.createElement('button');
                miNodoBoton.classList.add('w3-button', 'w3-theme');
                miNodoBoton.textContent = '+';
                miNodoBoton.setAttribute('marcador', info.id);
                miNodoBoton.addEventListener('click', anyadirProductoAlCarrito);
                // Insertamos
                miNodoCardBody.appendChild(miNodoImagen);
                miNodoCardBody.appendChild(miNodoTitle);
                miNodoCardBody.appendChild(miNodoPrecio);
                miNodoCardBody.appendChild(miNodoBoton);
                miNodo.appendChild(miNodoCardBody);
                DOMitems.appendChild(miNodo);
            });
        }

        /**
         * Evento para añadir un producto al carrito de la compra
         */
        function anyadirProductoAlCarrito(evento) {
            // Anyadimos el Nodo a nuestro carrito
            carrito.push(evento.target.getAttribute('marcador'))
            // Calculo el total
            calcularTotal();
            // Actualizamos el carrito 
            renderizarCarrito();

        }

        /**
         * Dibuja todos los productos guardados en el carrito
         */
        function renderizarCarrito() {
            // Vaciamos todo el html
            DOMcarrito.textContent = '';
            // Quitamos los duplicados
            const carritoSinDuplicados = [...new Set(carrito)];
            // Generamos los Nodos a partir de carrito
            carritoSinDuplicados.forEach((item) => {
                // Obtenemos el item que necesitamos de la variable base de datos
                const miItem = baseDeDatos.filter((itemBaseDatos) => {
                    // ¿Coincide las id? Solo puede existir un caso
                    return itemBaseDatos.id === parseInt(item);
                });
                // Cuenta el número de veces que se repite el producto
                const numeroUnidadesItem = carrito.reduce((total, itemId) => {
                    // ¿Coincide las id? Incremento el contador, en caso contrario no mantengo
                    return itemId === item ? total += 1 : total;
                }, 0);
                // Creamos el nodo del item del carrito
                const miNodo = document.createElement('li');
                miNodo.classList.add('list-group-item', 'text-right');
                miNodo.textContent = `${numeroUnidadesItem} x ${miItem[0].nombre} - ${miItem[0].precio}€`;
                // Boton de borrar
                const miBoton = document.createElement('button');
                miBoton.classList.add('w3-button', 'w3-red', 'w3-margin');
                miBoton.textContent = 'X';
                miBoton.style.marginLeft = '1rem';
                miBoton.dataset.item = item;
                miBoton.addEventListener('click', borrarItemCarrito);
                // Mezclamos nodos
                miNodo.appendChild(miBoton);
                DOMcarrito.appendChild(miNodo);
            });
        }

        /**
         * Evento para borrar un elemento del carrito
         */
        function borrarItemCarrito(evento) {
            // Obtenemos el producto ID que hay en el boton pulsado
            const id = evento.target.dataset.item;
            // Borramos todos los productos
            carrito = carrito.filter((carritoId) => {
                return carritoId !== id;
            });
            // volvemos a renderizar
            renderizarCarrito();
            // Calculamos de nuevo el precio
            calcularTotal();
        }

        /**
         * Calcula el precio total teniendo en cuenta los productos repetidos
         */
        function calcularTotal() {
            // Limpiamos precio anterior
            total = 0;
            // Recorremos el array del carrito
            carrito.forEach((item) => {
                // De cada elemento obtenemos su precio
                const miItem = baseDeDatos.filter((itemBaseDatos) => {
                    return itemBaseDatos.id === parseInt(item);
                });
                total = total + miItem[0].precio;
            });
            // Renderizamos el precio en el HTML
            DOMtotal.textContent = total.toFixed(2);
        }

        /**
         * Varia el carrito y vuelve a dibujarlo
         */
        function vaciarCarrito() {
            // Limpiamos los productos guardados
            carrito = [];
            // Renderizamos los cambios
            renderizarCarrito();
            calcularTotal();
        }

        // Eventos
        DOMbotonVaciar.addEventListener('click', vaciarCarrito);

        // Inicio
        renderizarProductos();


    }
</script>

<div class="w3-container">
    <div class="w3-row">
        <!-- Elementos generados a partir del JSON -->
        <main id="items" class="w3-col l9 m9 w3-row">
            <!-- CABECERA -->

            <div class="w3-margin-top">
                <div class="w3-container w3-center">
                    <div class="w3-quarter">
                        <a href="index.php"><img src="../img/ccms_logo.png" alt="C C M S" class="w3-image" width="60"></a>

                    </div>
                    <div class="w3-half w3-padding">
                        <h3 class="w3-text-theme w3-white w3-border w3-border-theme w3-round">Cannabis Club System Management</h3>
                    </div>
                </div>

                <!-- MENÚ -->

                <div class="w3-container">
                    <div class="w3-cell-row" style="margin:0 auto; padding: 0 23%;">

                        <!-- DISPENSARIO -->

                        <div class="w3-cell w3-center w3-mobile">

                            <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="menu.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                <i class="fas fa-store w3-xxlarge"></i>
                                <p class="w3-small" style="margin:0;">Menu</p>
                            </a>

                        </div>

                        <!-- ADMINISTRACIÓN -->

                        <div class="w3-cell w3-center w3-mobile">

                            <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="../admin/home/index.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                <i class="fas fa-cogs w3-xxlarge"></i>
                                <p class="w3-small" style="margin:0;">Administración</p>
                            </a>

                        </div>

                        <div class="w3-cell w3-center w3-mobile">

                            <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="stock.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                <i class="fas fa-seedling w3-xxlarge"></i>
                                <p class="w3-small" style="margin:0;">Stock</p>
                            </a>

                        </div>

                        <!-- Socios -->

                        <div class="w3-cell w3-center w3-mobile">

                            <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="socios.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                <i class="fas fa-user-cog w3-xxlarge"></i>
                                <p class="w3-small" style="margin:0;">Socios</p>
                            </a>

                        </div>

                        <!-- Administración -->

                        <div class="w3-cell w3-center w3-mobile">

                            <a class="w3-border w3-border-theme w3-round w3-white w3-hover-theme  w3-text-theme w3-button" href="../admin/gestionarSocios.php" style="text-decoration:none; width: 110px; padding: 10px;">
                                <i class="fas fa-chart-line w3-xxlarge"></i>
                                <p class="w3-small" style="margin:0;">Finanzas</p>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </main>
        <!-- Carrito -->
        <aside class="w3-col l3 m3">
            <div class="w3-row-padding">
                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                    <div class="w3-col l6 m6">
                        <input type="text">
                    </div>
                    <div class="w3-col l6 m6">
                        <input type="text">
                    </div>
                </div>
            </div>
            <div class="w3-row-padding w3-margin-top">
                <div class="w3-container w3-padding w3-border w3-border-theme w3-round">
                    <h2>Carrito</h2>
                    <!-- Elementos del carrito -->
                    <ul id="carrito" class="list-group"></ul>
                    <hr>
                    <!-- Precio total -->
                    <p class="text-right">Total: <span id="total"></span>&euro;</p>
                    <button id="boton-vaciar" class="w3-button w3-red">Vaciar</button>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include '../templates/footer.php'  ?>