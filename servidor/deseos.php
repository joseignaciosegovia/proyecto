<?php
    session_start();

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        // NO HACE NADA
        echo "Tiene que iniciar sesión para poder guardar productos en la lista de deseos";
        header("Location: ../index.php");
        exit();
    }

    require_once "../controlador/Crud.php";

    $crud = new Crud();

    $producto = json_decode($_POST['producto']);

    $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);
    // Añadimos el artículo al final del array de deseos
    $cliente->deseos[] = ["nombre" => $producto[0], "precio" => $producto[1], "fecha" => date('Y-m-d h:i:s a', time())];

    // Añadimos la lista de deseos al perfil del usuario en la base de datos
    $crud->actualizarDatos("clientes", ["usuario" => $_SESSION['cliente']], ["deseos" => $cliente->deseos]);
    echo "Se ha añadido el producto $producto[0] a la lista de deseos ";