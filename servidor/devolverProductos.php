<?php

    require_once "../controlador/Crud.php";

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

    $js = "function() {
        return this->precio_actual != this->precio_original;
    }";
    
    // Listamos los productos en función de la opción elegida
    $productos = $crud->listarDatos("productos", $consulta, $opciones);
    $enviar = [];
    foreach($productos as $producto) {
        if($seleccion == "ofertas"){
            if($producto->precio_actual != $producto->precio_original){
                array_push($enviar, $producto);
            }
        }
        else{
            array_push($enviar, $producto);
        }
    }

    // Enviamos los productos que se mostrarán posteriormente
    echo json_encode($enviar);
?>