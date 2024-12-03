import {handle_cerrarClientes} from './main.js'

const btnCerrarClientes = document.querySelector(".btn-salir");
btnCerrarClientes.addEventListener("click", handle_cerrarClientes('trabajador'));