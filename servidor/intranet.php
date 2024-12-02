<?php
    session_start();

    require_once "../controlador/Crud.php";

    // Si no hemos iniciado sesión como trabajador, volvemos a la página de inicio de sesión de los trabajadores
    if (empty($_SESSION["trabajador"])) {
        header("Location: servidor.php");
        exit();
    }

    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Intranet</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
            <!-- Google Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Animanate CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
            <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        </head>
        <body>
            <header>
                <h1>Intranet</h1>
            </header>
    <?php
    switch ($_SESSION['departamento']) {
        case 'Compras':
            echo "<h3>Departamento de compras</h3>";
            echo "<h4>Productos</h4>";
            $crud = new Crud("userTienda", "1234");
            $opciones = ["sort" => ["stock" => 1]];
            // Obtenemos los productos ordenados por stock
            $productos = $crud->listarDatos("productos", [], $opciones);
                ?>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Precio actual</th>
                        <th>Precio original</th>
                        <th>Stock</th>
                    </thead>
                    <tbody>
                        <?php
                            $cont = 1;
                            foreach($productos as $producto){
                        ?>
                        <tr>
                            <th><?php echo $cont ?></th>
                            <td><?php echo $producto->nombre ?></td>
                            <td><?php echo $producto->categoria ?></td>
                            <td><?php echo $producto->descripcion ?></td>
                            <td><?php echo $producto->precio_actual ?></td>
                            <td><?php echo $producto->precio_original ?></td>
                            <td><?php echo $producto->stock ?></td>
                        </tr>
                            <?php 
                                $cont++;
                            } 
                            ?>
                    </tbody>
                </table>
                <?php
                    $proveedores = $crud->listarDatos("proveedores", [], []);
                ?>
            <h4>Proveedores</h4>
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Localidad</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Productos</th>
                </thead>
                <tbody>
                    <?php
                        $cont = 1;
                        foreach($proveedores as $proveedor){
                    ?>
                    <tr>
                        <th><?php echo $cont ?></th>
                        <td><?php echo $proveedor->nombre ?></td>
                        <td><?php echo $proveedor->direccion ?></td>
                        <td><?php echo $proveedor->localidad ?></td>
                        <td><?php echo $proveedor->email ?></td>
                        <td><?php echo $proveedor->telefono ?></td>
                        <td>
                            <select name="productos" id="productos">
                                <?php
                                foreach($proveedor->productos_id as $producto_id){
                                    $producto = $crud->obtenerDatos("productos", ["_id" => $producto_id], []);
                                    echo "<option>$producto->nombre</option>";
                                }
                                $cont++;
                                ?>
                            </select>
                        </td>
                    </tr>
                        <?php } ?>
                </tbody>
            </table>
            <?php

            breaK;
        case 'Análisis':
            echo "Departamento de análisis";
            breaK;
        case 'Gestión':
            echo "<h3>Departamento de gestión</h3>";
            echo "<h4>Clientes</h4>";
            $crud = new Crud("userTienda", "1234");
            $contraseñasCl = $crud->listarDatos("contraseñasCl", [], []);
                ?>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Usuario</th>
                        <th>Hash de la contraseña</th>
                    </thead>
                    <tbody>
                        <?php
                            $cont = 1;
                            foreach($contraseñasCl as $contraseñaCl){
                                $cliente = $crud->obtenerDatos("clientes", ["_id" => $contraseñaCl->cliente_id], []);
                        ?>
                        <tr>
                            <th><?php echo $cont ?></th>
                            <td><?php echo $cliente->nombreCompleto ?></td>
                            <td><?php echo $contraseñaCl->usuario ?></td>
                            <td><?php echo $contraseñaCl->contraseña ?></td>
                        </tr>
                            <?php 
                                $cont++;
                            } 
                            ?>
                    </tbody>
                </table>
                <?php
            
            echo "<h4>Trabajadores</h4>";
            $contraseñasTr = $crud->listarDatos("contraseñasTr", [], []);
                ?>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Trabajador</th>
                        <th>Usuario</th>
                        <th>Departamento</th>
                        <th>Hash de la contraseña</th>
                    </thead>
                    <tbody>
                        <?php
                            $cont = 1;
                            foreach($contraseñasTr as $contraseñaTr){
                                $usuario = $crud->obtenerDatos("trabajadores", ["_id" => $contraseñaTr->trabajador_id], []);
                        ?>
                        <tr>
                            <th><?php echo $cont ?></th>
                            <td><?php echo $usuario->nombre ?></td>
                            <td><?php echo $contraseñaTr->usuario ?></td>
                            <td><?php echo $usuario->departamento ?></td>
                            <td><?php echo $contraseñaTr->contraseña ?></td>
                        </tr>
                            <?php 
                                $cont++;
                            } ?>
                    </tbody>
                </table>
                <?php
            breaK;
        case 'Servicio Técnico':
            echo "<h3>Departamento de servicio técnico</h3>";
            echo "<h4>Quejas y sugerencias de clientes</h4>";
            $crud = new Crud("userTienda", "1234");
            $clientes = $crud->listarDatos("clientes", [], []);
                ?>
                <table class="table table-hover">
                    <thead>
                        <th>Nombre Usuario</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </thead>
                    <tbody>
                        <?php
                        // Recorremos cada cliente
                        foreach($clientes as $cliente){
                            // Si el cliente tiene alguna queja la mostramos
                            if($cliente->quejas->count() != 0){
                                echo "<tr>";
                                $numeroQuejas = $cliente->quejas->count();
                                echo "<th rowspan=$numeroQuejas>$cliente->nombreCompleto</th>";
                                foreach($cliente->quejas as $queja){
                                    echo "<td>$queja->descripcion</td>";
                                    echo "<td>$queja->fecha</td>";
                                    echo "</tr>";
                                }
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            breaK;
    }
?>