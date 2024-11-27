<?php
    require_once __DIR__ . "/../clases/Crud.php";

    $crud = new Crud();
    // Obtenemos los ordenadores
    $consulta = ["categoria" => "Ordenador"];
    $productos = $crud->listarDatos("productos", $consulta, []);
    $ordenadores = [];
    foreach($productos as $producto) {
        array_push($ordenadores, $producto);
    }

    echo json_encode($ordenadores);
?>