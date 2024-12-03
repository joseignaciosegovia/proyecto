// Iconos
const carritoIcono = document.querySelector('.bi-cart-dash');
const cesta = document.getElementById('cesta');
const cerrarCarrito = document.querySelector("#cart-close");

const lupaIcono = document.querySelector('.bi-search');
const usuarioIcono = document.querySelector('.bi-person-circle');
const seccionUsuario = document.getElementById('usuario');
const cerrarCesta = document.querySelector('#cerrarCesta');
const novedades = document.querySelector('#novedades');
const ofertas = document.querySelector('#ofertas');
const ordenadores = document.querySelector('#ordenadores');
const componentes = document.querySelector('#componentes');

// Botón "Novedades"
const nov_btn = document.querySelectorAll(".btn-group button")[0];
nov_btn.addEventListener("click", cargarNovedades);

// Botón "Ofertas"
const ofe_btn = document.querySelectorAll(".btn-group button")[1];
ofe_btn.addEventListener("click", cargarOfertas);

// Botón "Ordenadores"
const ord_btn = document.querySelectorAll(".btn-group button")[2];
ord_btn.addEventListener("click", cargarOrdenadores);

// Botón "Componentes"
const com_btn = document.querySelectorAll(".btn-group button")[3];
com_btn.addEventListener("click", cargarComponentes);

// Botón para comprar
const comprar_btn = document.querySelector(".btn-comprar");
comprar_btn.addEventListener("click", handle_buyOrden);

// Botón para el acceso de los trabajadores
const btnTrabajadores = document.querySelector(".btn-trabajadores");
btnTrabajadores.addEventListener("click", handle_trabajadores);

// Botón para el acceso de los clientes
const btnClientes = document.querySelector(".btn-usu");
btnClientes.addEventListener("click", handle_clientes);

// Botón para el registro de los clientes
const btnRegistroClientes = document.querySelector(".btn-login");
btnRegistroClientes.addEventListener("click", handle_registroClientes);

// Productos del carrito
let productosCarrito = [];

// Pulsamos en el icono del carrito
carritoIcono.addEventListener("click", () => {
    cesta.style.display = "block";
});

// Pulsamos en el icono del usuario
usuarioIcono.addEventListener("click", () => {

    // Comprobamos si hay un usuario logeado

    fetch('public/devolverCliente.php', {
        method: 'get'
      }).then ((response) => response.json()
      ).then(function (data) {
        if(data){
            seccionUsuario.replaceChildren();
            seccionUsuario.insertAdjacentHTML('beforeend', `</br></br><a href="public/perfil.php">Perfil</a></br>
                <a href="public/historialCompras.php">Historial de compras</a></br>
                <a>Lista de deseos</a></br>
                <a href="public/quejas.php">Quejas y sugerencias</a></br>
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

    cargarNovedades();
});

// Actualizar carrito
function update() {
    eventosCarrito();
    updateTotal();
}

function eventosCarrito() {

    // Botón para eliminar artículos del carrito
    let cartRemove_btns = document.querySelectorAll(".eliminar-cesta");

    cartRemove_btns.forEach((btn) => {
        btn.addEventListener("click", handle_removeCartItem);
    });

    // Botón para cambiar la cantidad de artículos del carrito
    let cartQuantity_inputs = document.querySelectorAll(".cantidad-cesta");

    cartQuantity_inputs.forEach((input) => {
        input.addEventListener("change", handle_changeItemQuantity);
    });

    // Botón para añadir artículos al carrito
    let addCart_btns = document.querySelectorAll(".add-cart");

    addCart_btns.forEach((btn) => {
        btn.addEventListener("click", handle_addCartItem);
    });
}

// Manejador del botón para añadir artículos al carrito
function handle_addCartItem() {
    let producto = this.parentElement;
    let nombre = producto.querySelectorAll('p')[0].innerHTML;
    let precioTexto = producto.querySelectorAll('p')[1].textContent;
    // Eliminar símbolos de moneda y separadores de miles
    let precio = parseFloat(precioTexto.replace("€", "").replace(".", "")); 

    let rutaImagen = producto.querySelector('img').src;
    
    let productoAñadir = {
        nombre: nombre,
        precio: precio,
        rutaImagen: rutaImagen
    };
    
    if(productosCarrito.find((productoExistente) => productoExistente.nombre === productoAñadir.nombre)){
        alert("Este Articulo Ya Existe");
    } else {
        productosCarrito.push(productoAñadir);
    }
    
    // Añadir productos al carrito

    let carBoxElemento = cartBoxComponent(nombre, precio, rutaImagen);
    let nuevoNodo = document.createElement("div");
    nuevoNodo.innerHTML = carBoxElemento;
    const cartContenido = cesta.querySelector(".cart-content");
    cartContenido.appendChild(nuevoNodo);

    // Activar el icono del carrito
    cesta.style.display = "block";

    update()
};

function handle_removeCartItem() {
    this.parentElement.remove();

    productosCarrito = productosCarrito.filter(
        (el) => el.title !== this.parentElement.querySelector(".nombre-producto-cesta").innerHTML
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

    // Si se intenta comprar hacer de hacer un pedido
    if(productosCarrito.length <= 0){
        alert("No tiene ningún producto en la cesta");
        return;
    }
    const cartContent = cesta.querySelector(".cart-content");
    cartContent.innerHTML = "";
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

// Pulsamos el botón 'Cerrar sesión'
function handle_cerrarClientes() {
    fetch('public/cerrar.php', {
        method: 'get'
      }).then((response) => response.text())
      .then(function(data) {
        window.open("index.php", "_self");
      }).catch(function(data) {
        console.log("Error");
      }
    );
}

// Actualizar y renderizar
function updateTotal() {
    let cartBoxes = document.querySelectorAll('.cesta-box');
    const totalElement = cesta.querySelector(".precio-total");
    let total=0;

    cartBoxes.forEach((cartBox) => {
        let precioElemento  = cartBox.querySelector(".precio-cesta");
        let precio = parseFloat(precioElemento.innerHTML.replace("€", ""));
        let cantidad = cartBox.querySelector(".cantidad-cesta").value;

        total += precio * cantidad;
    });

    total = total.toFixed(2);

    totalElement.innerHTML = total + "€";
}

function cartBoxComponent(nombre, precio, rutaImagen) {
    return `
    <div class="cesta-box">
        <img src="${rutaImagen}" alt="" class="imagen-cesta">
        <div class="detail-box">
        <div class="nombre-producto-cesta">${nombre}</div>
        <div class="precio-cesta">${precio}€</div>
        <input type="number" value="1" class="cantidad-cesta">
    </div>

    <!-- ELIMINAR CART -->
    <i class="bi bi-trash-fill eliminar-cesta"></i>
    `;
}

// Cargamos las novedades
async function cargarNovedades() {
    // Ocultamos el resto de secciones y mostramos la sección de novedades
    ofertas.style.display = "none";
    ordenadores.style.display = "none";
    componentes.style.display = "none";
    novedades.style.display = "block";
    
    novedades.replaceChildren();
    novedades.insertAdjacentHTML('beforeend', `<h2>Novedades</h2>`);

    const formData = new FormData();
    formData.append("data", "novedades");

    try {
        const respuesta = await fetch('servidor/devolverProductos.php', {
            method: 'post',
            body: formData
          });
        const datos = await respuesta.json();
        mostrarProductos(novedades, datos);
    } catch(error) {
        console.log("Error: " + error);
    }

    eventosCarrito();
}

// Cargamos las ofertas
function cargarOfertas() {
    // Ocultamos el resto de secciones y mostramos la sección de ofertas
    ofertas.style.display = "block";
    ordenadores.style.display = "none";
    componentes.style.display = "none";
    novedades.style.display = "none";

    ofertas.replaceChildren();
    ofertas.insertAdjacentHTML('beforeend', `<h2>Ofertas</h2>`);

    const formData = new FormData();
    formData.append("data", "ofertas");

    fetch('servidor/devolverProductos.php', {
        method: 'post',
        body: formData
      }).then ((response) => response.json()
      ).then(function (datos) {
        mostrarProductos(ofertas, datos);
      }).catch(function (err) {
        console.log("Ha habido un error");
      });
}

// Cargamos los ordenadores
function cargarOrdenadores() {
    // Ocultamos el resto de secciones y mostramos la sección de ordenadores
    ofertas.style.display = "none";
    ordenadores.style.display = "block";
    componentes.style.display = "none";
    novedades.style.display = "none";
    
    ordenadores.replaceChildren();
    ordenadores.insertAdjacentHTML('beforeend', `<h2>Ordenadores</h2>`);

    const formData = new FormData();
    formData.append("data", "ordenadores");

    fetch('servidor/devolverProductos.php', {
        method: 'post',
        body: formData
      }).then ((response) => response.json()
      ).then(function (datos) {
        mostrarProductos(ordenadores, datos);
      }).catch(function (err) {
        console.log("Ha habido un error");
      });
}

// Cargamos los componentes
function cargarComponentes() {
    // Ocultamos el resto de secciones y mostramos la sección de novedades
    ofertas.style.display = "none";
    ordenadores.style.display = "none";
    componentes.style.display = "block";
    novedades.style.display = "none";

    componentes.replaceChildren();
    componentes.insertAdjacentHTML('beforeend', `<h2>Componentes</h2>`);

    const formData = new FormData();
    formData.append("data", "componentes");

    fetch('servidor/devolverProductos.php', {
        method: 'post',
        body: formData
      }).then ((response) => response.json()
      ).then(function (datos) {
        mostrarProductos(componentes, datos);
      }).catch(function (err) {
        console.log("Ha habido un error");
      });
}

function mostrarProductos(productos, datos) {
    productos.insertAdjacentHTML('beforeend', `<div class="divProductos"></div>`);
    let divProductos = productos.childNodes[1];
    divProductos.replaceChildren();
    for(let i = 0; i < 6 && i < datos.length; i++) {
        divProductos.insertAdjacentHTML('beforeend', `<div class="productos">
            <img class="imagenProducto" src="img/${datos[i]['imagen']}"></img>
            <a href="productos/productos.php?producto=${datos[i]['nombre']}"><p>${datos[i]['nombre']}</p></a>
            <p>${datos[i]['precio_actual']}€</p>
        </div>`);
        if(datos[i]['precio_actual'] != datos[i]['precio_original']){
            divProductos.childNodes[i].insertAdjacentHTML('beforeend', `<strike>${datos[i]['precio_original']}€</strike>
            `);
        }
        divProductos.childNodes[i].insertAdjacentHTML('beforeend', `<i class="bi bi-bag-dash-fill add-cart"></i>
        `);
    }
}