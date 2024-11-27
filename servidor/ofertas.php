<?php
    require_once __DIR__ . "/../clases/Crud.php";

    $crud = new Crud();
    // AÑADIR CRITERIO PARA IDENTIFICAR OFERTAS
    
    $productos = $crud->listarDatos("productos", [], []);
    $ofertas = [];
    foreach($productos as $producto) {
        array_push($ofertas, $producto);
    }

    echo json_encode($ofertas);
?>