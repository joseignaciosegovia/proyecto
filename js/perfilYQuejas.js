// Iconos
let carrito = document.querySelector('.bi-cart-dash');
let lupa = document.querySelector('.bi-search');
let usuario = document.querySelector('.bi-person-circle');
let cesta = document.getElementById('cesta');
let seccionUsuario = document.getElementById('usuario');
let cerrarCesta = document.querySelector('#cerrarCesta');
let novedades = document.querySelector('#novedades');
let ofertas = document.querySelector('#ofertas');
let ordenadores = document.querySelector('#ordenadores');
let componentes = document.querySelector('#componentes');

// Botón para comprar
const buy_btn = document.querySelector(".btn-buy");
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

let itemsAdded = [];

// Pulsamos en el icono del carrito
carrito.addEventListener("click", () => {
    cesta.style.display = "block";
});

// Pulsamos en el icono del usuario
usuario.addEventListener("click", () => {

    // Comprobamos si hay un usuario logeado

    fetch('devolverCliente.php', {
        method: 'get'
      }).then ((response) => response.json()
      ).then(function (data) {
        if(data){
            seccionUsuario.replaceChildren();
            seccionUsuario.insertAdjacentHTML('beforeend', `</br></br><a href="perfil.php">Perfil</a></br>
                <a href="historialCompras.php">Historial de compras</a></br>
                <a>Lista de deseos</a></br>
                <a href="quejas.php">Quejas y sugerencias</a></br>
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
});

window.addEventListener('load', function() {
    cesta.style.display = "none";
    seccionUsuario.style.display = "none";
    addEvents();
});

function update() {
    addEvents();
    updateTotal();
}

function addEvents() {

    // Botón para eliminar artículos del carrito
    let cartRemove_btns = document.querySelectorAll(".cart-remove");

    cartRemove_btns.forEach((btn) => {
        btn.addEventListener("click", handle_removeCartItem);
    });

    // Botón para cambiar la cantidad de artículos del carrito
    let cartQuantity_inputs = document.querySelectorAll(".cart-quantity");

    cartQuantity_inputs.forEach((input) => {
        input.addEventListener("change", handle_changeItemQuantity);
    });

    // Botón para añadir artículos al carrito
    let addCart_btns = document.querySelectorAll(".add-cart");

    addCart_btns.forEach((btn) => {
        btn.addEventListener("click", handle_addCartItem);
    });
}

function handle_addCartItem() {
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

    let carBoxElement = cartBoxComponent(title, price, imgSrc);
    let newNode = document.createElement("div");
    newNode.innerHTML = carBoxElement;
    const cartContent = cart.querySelector(".cart-content");
    cartContent.appendChild(newNode);

    // Activar el icono del carrito
    cart.classList.add("active");

    update()
};

function handle_removeCartItem() {
    this.parentElement.remove();

    itemsAdded = itemsAdded.filter(
        (el) => el.title !== this.parentElement.querySelector(".cart-product-title").innerHTML
    );    
    update();
}

// Pulsamos el botón 'Cerrar sesión'
function handle_cerrarClientes() {
    fetch('../public/cerrar.php', {
        method: 'get'
      }).then((response) => response.text())
      .then(function(data) {
        window.open("../index.php", "_self");
      }).catch(function(data) {
        console.log("Error");
      }
    );
}

function handle_changeItemQuantity(){
    if(isNaN(this.value) || this.value < 1){
        this.value = 1;
    }

    // Para mantener el número entero
    this.value = Math.floor(this.value); 

    update();
}

function handle_buyOrden() {

    invocarNode();

    // Si se intenta comprar hacer de hacer un pedido
    if(itemsAdded.length <= 0){
        alert("No tiene ningún producto en la cesta");
        return;
    }
    const cartContent = cart.querySelector(".cart-content");
    cartContent.innerHTML = "";
    alert("Su pedido se realizó exitosamente")
    itemsAdded = [];
    update();
    
}

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
}

// Actualizar y renderizar
function updateTotal() {
    let cartBoxes = document.querySelectorAll('.cart-box');
    const totalElement = cart.querySelector(".total-price");
    let total=0;

    cartBoxes.forEach((cartBox) => {
        let priceElement  = cartBox.querySelector(".cart-price");
        let price = parseFloat(priceElement.innerHTML.replace("$", ""));
        let quantity = cartBox.querySelector(".cart-quantity").value;

        total += price * quantity;
    });

    total = total.toFixed(2);

    totalElement.innerHTML = "$" + total;
}

function cartBoxComponent(title, price, imgSrc) {
    return `
    <div class="cart-box">
        <img src="${imgSrc}" alt="" class="cart-img">
        <div class="detail-box">
        <div class="cart-product-title">${title}</div>
        <div class="cart-price">$${price}</div>
        <input type="number" value="1" class="cart-quantity">
    </div>

    <!-- ELIMINAR CART -->
    <i class="bx bxs-trash-alt cart-remove"></i>
    `;
}