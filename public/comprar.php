<?php
    session_start();

    require_once "../controlador/Crud.php";

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        header("Location: ../index.php");
        exit();
    }

    $productos = json_decode($_POST['productos']);
    $crud = new Crud();
    $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION["cliente"]], []);
    foreach($productos as $producto) {
        $cliente->compras[] = ["nombre" => $producto->nombre, "precio" => $producto->precio, "fecha" => date('Y-m-d h:i:s a', time())];
        $crud->actualizarDatos("clientes", ["usuario" => $_SESSION["cliente"]], ["compras" => $cliente->compras]);
    }