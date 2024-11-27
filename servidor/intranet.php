<?php
    session_start();

    require_once __DIR__ . "/../clases/Crud.php";

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
            <link rel="stylesheet" type="text/css" href="./css/estilos.css">
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
            $productos = $crud->listarDatos("productos");
                ?>
                <table>
                    <thead>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($productos as $producto){
                        ?>
                        <tr>
                            <td><?php echo $producto->nombre ?></td>
                            <td><?php echo $producto->categoria ?></td>
                            <td><?php echo $producto->descripcion ?></td>
                            <td><?php echo $producto->precio ?></td>
                            <td><?php echo $producto->stock ?></td>
                        </tr>
                            <?php } ?>
                    </tbody>
                </table>
                <?php
                    $proveedores = $crud->listarDatos("proveedores");
                ?>
            <h4>Proveedores</h4>
            <table>
                <thead>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Localidad</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Productos</th>
                </thead>
                <tbody>
                    <?php
                        foreach($proveedores as $proveedor){
                    ?>
                    <tr>
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
            $contraseñasCl = $crud->listarDatos("contraseñasCl");
                ?>
                <table>
                    <thead>
                        <th>Usuario</th>
                        <th>Hash de la contraseña</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($contraseñasCl as $contraseñaCl){
                        ?>
                        <tr>
                            <td><?php echo $contraseñaCl->usuario ?></td>
                            <td><?php echo $contraseñaCl->contraseña ?></td>
                        </tr>
                            <?php } ?>
                    </tbody>
                </table>
                <?php
            
            echo "<h4>Trabajadores</h4>";
            $contraseñasTr = $crud->listarDatos("contraseñasTr");
                ?>
                <table>
                    <thead>
                        <th>Trabajador</th>
                        <th>Hash de la contraseña</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($contraseñasTr as $contraseñaTr){
                        ?>
                        <tr>
                            <td><?php echo $contraseñaTr->usuario ?></td>
                            <td><?php echo $contraseñaTr->contraseña ?></td>
                        </tr>
                            <?php } ?>
                    </tbody>
                </table>
                <?php
            breaK;
        case 'Servicio Técnico':
            echo "Departamento de servicio técnico";
            breaK;
    }
?>