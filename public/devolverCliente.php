<?php
    session_start();

    //Hacemos el autoload de las clases
    spl_autoload_register(function ($class) {
        require "../clases/" . $class . ".php";
    });

    $nombreCliente = $_SESSION['cliente'];

    if($nombreCliente) {
        $crud = new Crud();
        $cliente = $crud->obtenerDatos("clientes", ["usuario" => $nombreCliente], []);

        $clienteJSON = json_encode($cliente);
        echo $clienteJSON;
    }

    else {
        $noCliente = json_encode(new stdClass);
        echo $noCliente;
    }

?>