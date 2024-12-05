import {
    manejadores,
    botonComprar,
    handle_añadirCarrito,
    handle_eliminarCesta,
    handle_cambiarCantidad
} from './funciones.js';

// Iconos
/*const carritoIcono = document.querySelector('.bi-cart-dash');
const cesta = document.getElementById('cesta');

const lupaIcono = document.querySelector('.bi-search');
const usuarioIcono = document.querySelector('.bi-person-circle');
const seccionUsuario = document.getElementById('usuario');
const cerrarCesta = document.querySelector('#cerrar-cesta');*/

/* Botones
// Botón para comprar
const buy_btn = document.querySelector(".btn-comprar");
buy_btn.addEventListener("click", handle_buyOrden);

// Botón para el acceso de los trabajadores
const btnTrabajadores = document.querySelector(".btn-trabajadores");
btnTrabajadores.addEventListener("click", handle_trabajadores);

// Botón para el acceso de los clientes
const btnClientes = document.querySelector(".btn-usu");
btnClientes.addEventListener("click", handle_clientes);

// Botón para el registro de los clientes
const btnRegistroClientes = document.querySelector(".btn-login");
btnRegistroClientes.addEventListener("click", handle_registroClientes);

let itemsAdded = [];*/

// Botón para comprar
/*const comprar_btn = document.querySelector(".btn-comprar");
comprar_btn.addEventListener("click", handle_buyOrden);*/

/*botonComprar();
manejadores();*/

/*
// Pulsamos en el icono del carrito
carritoIcono.addEventListener("click", () => {
    cesta.style.display = "block";
});

// Pulsamos en el icono del usuario
usuarioIcono.addEventListener("click", () => {

    // Comprobamos si hay un usuario logeado

    fetch('devolverCliente.php', {
        method: 'get'
      }).then ((response) => response.json()
      ).then(function (data) {
        if(data){
            seccionUsuario.replaceChildren();
            seccionUsuario.insertAdjacentHTML('beforeend', `</br></br><a href="/Aplicacion/public/perfil.php">Perfil</a></br>
                <a href="/Aplicacion/public/historialCompras.php">Historial de compras</a></br>
                <a href="/Aplicacion/public/listaDeseos.php">Lista de deseos</a></br>
                <a href="/Aplicacion/public/quejas.php">Quejas y sugerencias</a></br>
                <i class="bi bi-x-circle" id="cerrarUsuario"></i>
                <button type="button" class="btn-salir">Cerrar sesión</button>`);
        }
        
        // Botón para cerrar sesión de los clientes
        const btnCerrarClientes = document.querySelector(".btn-salir");
        btnCerrarClientes.addEventListener("click", handle_cerrarClientes);
        seccionUsuario.style.display = "block";
        // FUNCIONA MAL!!!!!!!
      }).catch(function (err) {
        console.log("Ha habido un error");
        seccionUsuario.style.display = "block";
      });
});

// Pulsamos el botón de cerrar en el menú de la cesta
cerrarCesta.addEventListener("click", () => {
    cesta.style.display = "none";
});

// Pulsamos el botón de cerrar en el menú del usuario
seccionUsuario.addEventListener("click", () => {
    seccionUsuario.style.display = "none";
});*/

window.addEventListener('load', function() {
    botonComprar();
    manejadores();
    const seccionUsuario = document.getElementById('usuario');
    cesta.style.display = "none";
    seccionUsuario.style.display = "none";
    eventos();
});
/*
function update() {
    eventos();
    updateTotal();
}*/

function eventos() {

    // Botón para eliminar artículos del carrito
    let eliminarCesta_btns = document.querySelectorAll(".eliminar-cesta");

    eliminarCesta_btns.forEach((btn) => {
        btn.addEventListener("click", handle_eliminarCesta);
    });

    // Botón para cambiar la cantidad de artículos del carrito
    let cantidadCesta_inputs = document.querySelectorAll(".cantidad-cesta");

    cantidadCesta_inputs.forEach((input) => {
        input.addEventListener("change", handle_cambiarCantidad);
    });

    // Botón para añadir artículos al carrito
    let añadirCarrito = document.querySelectorAll(".add-cart");

    añadirCarrito.forEach((boton) => {
        boton.addEventListener("click", handle_añadirCarrito);
    });
}

/*
function handle_añadirCarrito() {
    let product = this.parentElement;
    console.log(product);
    let title = product.querySelector(".product-title").innerHTML;
    let priceText = product.querySelector(".product-price").textContent;
    // Eliminar símbolos de moneda y separadores de miles
    let price = parseFloat(priceText.replace("€", "").replace(".", "")); 

    let imgSrc = product.querySelector(".product-img").src;

    console.log(title, price, imgSrc);
    
    let newToAdd = {
        title,
        price,
        imgSrc
    };
    
    if(itemsAdded.find((el) => el.title === newToAdd.title)){
        alert("Este Articulo Ya Existe");
    } else {
        itemsAdded.push(newToAdd);
    }
    
    // Añadir productos al carrito

    let carBoxElement = cestaBoxComponent(title, price, imgSrc);
    let newNode = document.createElement("div");
    newNode.innerHTML = carBoxElement;
    const cartContent = cart.querySelector(".cart-content");
    cartContent.appendChild(newNode);

    // Activar el icono del carrito
    cart.classList.add("active");

    update()
};*/
/*
function handle_eliminarCesta() {
    this.parentElement.remove();

    itemsAdded = itemsAdded.filter(
        (el) => el.title !== this.parentElement.querySelector(".nombre-producto-cesta").innerHTML
    );    
    update();
}*/
/*
// Pulsamos el botón 'Cerrar sesión'
function handle_cerrarClientes() {
    fetch('/Aplicacion/public/cerrar.php', {
        method: 'get'
      }).then((response) => response.text())
      .then(function(data) {
        window.open("../index.php", "_self");
      }).catch(function(data) {
        console.log("Error");
      }
    );
}*/
/*function handle_cambiarCantidad(){
    if(isNaN(this.value) || this.value < 1){
        this.value = 1;
    }

    // Para mantener el número entero
    this.value = Math.floor(this.value); 

    update();
}*/

/*function handle_buyOrden() {

    // Si se intenta comprar antes de hacer un pedido
    if(productosCarrito.length <= 0){
        alert("No tiene ningún producto en la cesta");
        return;
    }
    const contenidoCesta = cesta.querySelector(".contenido-cesta");
    contenidoCesta.innerHTML = "";
    alert("Su pedido se realizó exitosamente")

    const formData = new FormData();
    formData.append("productos", JSON.stringify(productosCarrito));

    fetch('public/comprar.php', {
        method: 'post',
        body: formData
      }).then((response) => response.text())
      .then(function(data) {

      }).catch(function(data) {
        console.log("Error");
      }
    );

    productosCarrito = [];
    update();
    
}*/
/*
// Pulsamos el botón 'Acceso a trabajadores'
function handle_trabajadores() {
    // Abrimos una pestaña con el acceso a los trabajadores
    window.open("servidor/servidor.php", "Intranet");
}

// Pulsamos el botón 'Acceso a Usuarios'
function handle_clientes() {
    // Abrimos en la misma pestaña el acceso a los usuarios
    window.open("public/accesoCliente.php", "_self");
}

// Pulsamos el botón 'Registrarse'
function handle_registroClientes() {
    // Abrimos en la misma pestaña el registro de los clientes
    window.open("public/registroCliente.php", "_self");
}*/
/*
// Actualizar y renderizar
function updateTotal() {
    let cestaBoxes = document.querySelectorAll('.cesta-box');
    const totalElement = cesta.querySelector(".precio-total");
    let total=0;

    cestaBoxes.forEach((cestaBox) => {
        let precioElemento  = cestaBox.querySelector(".precio-cesta");
        let precio = parseFloat(precioElemento.innerHTML.replace("€", ""));
        let cantidad = cestaBox.querySelector(".cantidad-cesta").value;

        total += precio * cantidad;
    });

    total = total.toFixed(2);

    totalElement.innerHTML = total + "€";
}*/
/*
function cestaBoxComponent(nombre, precio, rutaImagen) {
    return `
    <div class="cesta-box">
        <img src="${rutaImagen}" alt="" class="imagen-cesta">
        <div class="detail-box">
        <div class="nombre-producto-cesta">${nombre}</div>
        <div class="precio-cesta">$${precio}</div>
        <input type="number" value="1" class="cantidad-cesta">
    </div>

    <!-- ELIMINAR CART -->
    <i class="bx bxs-trash-alt eliminar-cesta"></i>
    `;
}*/