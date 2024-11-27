<?php
    require_once __DIR__ . "/../clases/Crud.php";

    $crud = new Crud();
    $productos = $crud->listarDatos("productos");
    $novedades = [];
    foreach($productos as $producto) {
        array_push($novedades, $producto);
    }

    echo json_encode($novedades);
?>