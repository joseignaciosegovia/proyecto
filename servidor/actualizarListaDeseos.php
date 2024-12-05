<?php
    session_start();

    if(!isset($_REQUEST['datos'])){
        header("Location: /Aplicacion/index.php");
        exit();
    }

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        echo "Tiene que iniciar sesión para poder guardar productos en la lista de deseos";
        exit();
    }

    require_once "../controlador/Crud.php";

    $crud = new Crud();

    $datos = json_decode($_REQUEST['datos']);

    switch($datos[0]) {
        case 'añadir':
            $producto = json_decode($_POST['producto']);

            $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);
        
            foreach($cliente->deseos as $deseo){
                if($deseo->nombre == $producto[1]){
                    echo "Ya existe el producto en la lista de deseos";
                    exit();
                }
            }
            
            // Añadimos el artículo al final del array de deseos
            $cliente->deseos[] = ["nombre" => $producto[1], "precio" => $producto[2], "fecha" => date('Y-m-d h:i:s a', time())];
        
            // Añadimos la lista de deseos al perfil del usuario en la base de datos
            $crud->actualizarDatos("clientes", ["usuario" => $_SESSION['cliente']], ["deseos" => $cliente->deseos]);
            echo "Se ha añadido el producto $producto[1] a la lista de deseos ";
            break;
        case 'eliminar':
            $productosEliminar = $datos[1];

            $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);

            $encontrado;
            $listaDeseos = [];
            
            foreach($cliente->deseos as $deseo) {
                $encontrado = false;
                foreach($productosEliminar as $producto){
                    if($deseo->nombre == $producto){
                        $encontrado = true;
                        break;
                    }
                }
                if(!$encontrado){
                    $listaDeseos[] = ["nombre" => $deseo->nombre, "precio" => $deseo->precio, "fecha" => $deseo->fecha];
                }
            }

            $crud->actualizarDatos("clientes", ["usuario" => $_SESSION['cliente']], ["deseos" => $listaDeseos]);
            echo "Se han borrado los productos seleccionados de la lista de deseos ";
            
            break;
    }