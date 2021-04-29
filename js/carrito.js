let $tab1 = document.querySelector('#tab1');
let $tab2 = document.querySelector('#tab2');
let $tab3 = document.querySelector('#tab3');
let $tab4 = document.querySelector('#tab4');
let $tab5 = document.querySelector('#tab5');
let $tab6 = document.querySelector('#tab6');
let $tab7 = document.querySelector('#tab7');
let carrito = [];
let total = 0;
let $carrito = document.querySelector('#carrito');
let $total = document.querySelector('#total');
let $botonVaciar = document.querySelector('#boton-vaciar');

// Funciones
function renderItems(value) {
    categoria = value.toString();
    console.log("nombre de la categoria: " + categoria);
    console.log("Longitud de la array " + value.toString().length);
    console.log("Inicio del loop.")
    for (const iterator of object) {
        
    }
    {
        console.log(count);
        let ficha = "<div class='producto w3-col l2 m3 w3-margin-bottom w3-padding'>"+
                        "<div class='w3-container w3-border w3-round w3-padding-frame-tiny'>"+
                            "<div class='w3-container'>"+
                                "<h3 class='font-oswald w3-theme'>" + flores['nombre_articulo'] + "</h3>"+
                            "</div"+
                        "</div>"+
                    "</div>";
        // let miNodoImagePrice = document.createElement('div'); 
        // miNodoImagePrice.classList.add('w3-row');
        // //Contenedor de imagen
        // let catFlores4 = document.createElement('div');
        // catFlores4.classList.add('w3-col', 'l6', 'm6', 's6', 'w3-padding-frame-tiny');
        // let catFlores5 = document.createElement('img');
        // catFlores5.setAttribute('src', value['imagen_articulo']);
        // catFlores5.classList.add('w3-image');
        // catFlores4.appendChild(catFlores5);
        // //Contenedor precio
        // let catFlores6 = document.createElement('div');
        // catFlores6.classList.add('w3-col', 'l6', 'm6', 's6', 'w3-padding-frame-tiny');
        // let catFlores7 = document.createElement('p');
        // catFlores7.classList.add('w3-xxlarge');
        // catFlores7.textContent = value['precio_venta'];
        // let catFlores8 = document.createElement('span');
        // catFlores8.classList.add('w3-small');
        // catFlores8.textContent = " €/gr";
        // catFlores7.appendChild(catFlores8);
        // //Variedad
        // let catFlores9 = document.createElement('span');
        // catFlores9.classList.add('w3-orange', 'w3-text-dark-grey', 'w3-round-xxlarge', 'w3-padding-tiny');
        // catFlores9.textContent = value['variedad'];
        // catFlores6.appendChild(catFlores7);
        // catFlores6.appendChild(catFlores9);
        // //Contenedor casillas selección € Gr regalo
        // let catFlores10 = document.createElement('div');
        // catFlores10.classList.add('w3-row');
        // let catFlores11 = document.createElement('div');
        // catFlores11.classList.add('w3-col', 'l4', 'm4', 's4', 'w3-padding-frame-tiny');
        // let catFlores12 = document.createElement('input');
        // catFlores12.classList.add('w3-input', 'w3-border', 'w3-round', 'w3-xlarge');
        // catFlores12.setAttribute('placeholder', '€');
        // catFlores12.setAttribute('name', 'aport');
        // catFlores12.setAttribute("type", "text");
        // catFlores11.appendChild(catFlores12);
        // let catFlores13 = document.createElement('div');
        // catFlores13.classList.add('w3-col', 'l4', 'm4', 's4', 'w3-padding-frame-tiny');
        // let catFlores14 = document.createElement('input');
        // catFlores14.classList.add('w3-input', 'w3-border', 'w3-round', 'w3-xlarge');
        // catFlores14.setAttribute('placeholder', 'gr.');
        // catFlores14.setAttribute('data-price', value['precio_venta']);
        // catFlores13.appendChild(catFlores14);
        // let catFlores15 = document.createElement('div');
        // catFlores15.classList.add('w3-col', 'l4', 'm4', 's4', 'w3-padding-frame-tiny');
        // let catFlores16 = document.createElement('input');
        // catFlores16.classList.add('w3-input', 'w3-border', 'w3-round', 'w3-xlarge');
        // catFlores16.setAttribute('placeholder', 'gift')
        // catFlores15.appendChild(catFlores16);
        // catFlores10.appendChild(catFlores11);
        // catFlores10.appendChild(catFlores13);
        // catFlores10.appendChild(catFlores15);
        // // Botón Dispensar
        // let catFlores17 = document.createElement('div');
        // catFlores17.classList.add('w3-container', 'w3-padding-0');
        // let catFlores18 = document.createElement('button');
        // catFlores18.classList.add('w3-button', 'w3-theme-gradient-dark', 'w3-block');
        // catFlores18.addEventListener('click', anyadirCarrito);
        // catFlores18.setAttribute('marcador', value['id_articulo']);
        // catFlores18.textContent = 'Dispensar';
        // catFlores17.appendChild(catFlores18);
        // miNodoImagePrice.appendChild(catFlores4);
        // miNodoImagePrice.appendChild(catFlores6);
        // miNodoImagePrice.appendChild(catFlores10);
        // miNodoImagePrice.appendChild(catFlores17)
        document.getElementById('disp').innerHTML+=ficha;
    }
}
function anyadirCarrito() {
    // Anyadimos el Nodo a nuestro carrito
    carrito.push(this.getAttribute('marcador'));
    // Calculo el total
    calcularTotal();
    // Renderizamos el carrito 
    renderizarCarrito();
}
function renderizarCarrito() {
    // Vaciamos todo el html
    $carrito.textContent = '';
    // Quitamos los duplicados
    let carritoSinDuplicados = [...new Set(carrito)];
    // Generamos los Nodos a partir de carrito
    carritoSinDuplicados.forEach(function (item, indice) {
        // Obtenemos el item que necesitamos de la variable base de datos
        let selectionFlor = flores.filter(function (itemBaseDatos) {
            return itemBaseDatos['id_articulo'] == item;
        });
        // Cuenta el número de veces que se repite el producto
        let numeroUnidadesItem = carrito.reduce(function (total, itemId) {
            return itemId === item ? total += 1 : total;
        }, 0);
        // Creamos el nodo del item del carrito
        let registro = document.createElement('tr');
        let aporte = document.createElement('td');
        aporte.textContent = `${numeroUnidadesItem} gr.`;
        let variedad = document.createElement("td");
        variedad.textContent = `${selectionFlor[0]['nombre_articulo']}`;
        let coste = document.createElement('td');
        coste.classList.add('w3-right-align');
        coste.textContent =`${selectionFlor[0]['precio_venta']} €`;
        let borrar = document.createElement('td');
        borrar.classList.add('w3-right-align');
        let botonBorrar = document.createElement('a');
        botonBorrar.classList.add('w3-text-red');
        botonBorrar.setAttribute('item', item);
        botonBorrar.addEventListener('click', borrarItemCarrito);
        let papelera = document.createElement('i');
        papelera.classList.add('fas', 'fa-trash-alt');
        botonBorrar.appendChild(papelera);
        borrar.appendChild(botonBorrar);
        registro.appendChild(aporte);
        registro.appendChild(variedad);
        registro.appendChild(coste);
        registro.appendChild(borrar);
        $carrito.appendChild(registro);
    })
}
function borrarItemCarrito() {
    // Obtenemos el producto ID que hay en el boton pulsado
    let id = this.getAttribute('item');
    // Borramos todos los productos
    carrito = carrito.filter(function (carritoId) {
        return carritoId !== id;
    });
    // volvemos a renderizar
    renderizarCarrito();
    // Calculamos de nuevo el precio
    calcularTotal();
}
function calcularTotal() {
    // Limpiamos precio anterior
    total = 0;
    // Recorremos el array del carrito
    for (let item of carrito) {
        // De cada elemento obtenemos su precio
        let selectionFlor= flores.filter(function (itemBaseDatos) {
            return itemBaseDatos['id_articulo'] == item;
        });
        total = total + selectionFlor[0]['precio_venta'];
    }
    let totalDosDecimales = total.toFixed(2);
    // Renderizamos el precio en el HTML
    $total.textContent = totalDosDecimales;
}
function vaciarCarrito() {
    // Limpiamos los productos guardados
    carrito = [];
    // Renderizamos los cambios
    renderizarCarrito();
    calcularTotal();
}

// Eventos
// $botonVaciar.addEventListener('click', vaciarCarrito);

// Inicio