<?php

    //Hacemos el autoload de las clases
    spl_autoload_register(function ($class) {
        require "../clases/" . $class . ".php";
    });

    $crud = new Crud();
    // Guardamos la opción seleccionada
    $seleccion = $_POST['data'];

    switch($seleccion){
        case 'novedades':
            $consulta = [];
            // Obtenemos los productos ordenados por fecha
            $opciones = ["sort" => ["fecha" => -1]];
            break;
        case 'ofertas':
            // ESTABLECER UN CRITERIO PARA IDENTIFICAR OFERTAS
            $consulta = [];
            $opciones = [];
            break;
        case 'ordenadores':
            // Obtenemos los ordenadores
            $consulta = ["categoria" => "Ordenador"];
            $opciones = [];
            break;
        case 'componentes':
            // Obtenemos los componentes (productos que no son ordenadores)
            $consulta = ["categoria" => ["\$ne" => "Ordenador"]];
            $opciones = [];
            break;
    }
    
    // Listamos los productos en función de la opción elegida
    $productos = $crud->listarDatos("productos", $consulta, $opciones);
    $enviar = [];
    foreach($productos as $producto) {
        array_push($enviar, $producto);
    }

    // Enviamos los productos que se mostrarán posteriormente
    echo json_encode($enviar);
?>