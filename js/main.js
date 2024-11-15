// Iconos
let carrito = document.querySelector('.bi-cart-dash');
let lupa = document.querySelector('.bi-search');
let usuario = document.querySelector('.bi-person-circle');
let cesta = document.getElementById('cesta');
let crearUsuario = document.getElementById('usuario');
let cerrarCesta = document.querySelector('#cerrarCesta');

// Botón para comprar
const buy_btn = document.querySelector(".btn-buy");
buy_btn.addEventListener("click", handle_buyOrden);

// Botón para el acceso de los trabajadores
const btAcceso = document.querySelector(".btn-acceso");
btAcceso.addEventListener("click", handle_acceso);

let itemsAdded = [];

// Pulsamos en el icono del carrito
carrito.addEventListener("click", () => {
    cesta.style.display = "block";
});

// Pulsamos en el icono del usuario
usuario.addEventListener("click", () => {
    crearUsuario.style.display = "block";
});

// Pulsamos el botón de cerrar en el menú de la cesta
cerrarCesta.addEventListener("click", () => {
    cesta.style.display = "none";
});

// Pulsamos el botón de cerrar en el menú del usuario
crearUsuario.addEventListener("click", () => {
    crearUsuario.style.display = "none";
});

window.addEventListener('load', function() {
    cesta.style.display = "none";
    crearUsuario.style.display = "none";
    addEvents();

    novedades();
    ofertas();
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
function handle_acceso() {
    // Abrimos una pestaña con el acceso a los trabajadores
    window.open("servidor/servidor.php", "Intranet");
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

function novedades() {

}

function ofertas () {
    
}


function invocarNode() {
    fetch('/Aplicacion/nodejs/servidor.js', {
        method: 'post'
    }).then((response) => response.text())
    .then(function(data) {
    
        //console.log("Datos recibidos: ", data);
    
    }).catch(function(data) {
    
        console.log("Error");
    
    });
}
