<?php
    require_once __DIR__ . "/../clases/Crud.php";

    $crud = new Crud();
    // Obtenemos los productos ordenados por fecha
    $opciones = ["sort" => ["fecha" => -1]];
    $productos = $crud->listarDatos("productos", [], $opciones);
    $novedades = [];
    foreach($productos as $producto) {
        array_push($novedades, $producto);
    }

    echo json_encode($novedades);
?>