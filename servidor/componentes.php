<?php
    require_once __DIR__ . "/../clases/Crud.php";

    $crud = new Crud();
    // Obtenemos los componentes (productos que no son ordenadores)
    $consulta = ["categoria" => ["\$ne" => "Ordenador"]];
    $productos = $crud->listarDatos("productos", $consulta, []);
    $componentes = [];
    foreach($productos as $producto) {
        array_push($componentes, $producto);
    }

    echo json_encode($componentes);
?>