<?php
    require_once __DIR__ . "/../clases/Crud.php";

    $crud = new Crud();
    $seleccion = $_POST['data'];

    switch($seleccion){
        case 'ofertas':
            // ESTABLECER UN CRITERIO PARA IDENTIFICAR OFERTAS
            $consulta = [];
            $opciones = [];
            break;
        case 'novedades':
            $consulta = [];
            // Obtenemos los productos ordenados por fecha
            $opciones = ["sort" => ["fecha" => -1]];
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
    
    $productos = $crud->listarDatos("productos", $consulta, $opciones);
    $enviar = [];
    foreach($productos as $producto) {
        array_push($enviar, $producto);
    }

    echo json_encode($enviar);
?>