<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Listado</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body style="background-color:powderblue;">
        <h1 style="text-align:center;">Intranet</h1>
        <form method="post">
            <div class="container" style="margin: auto;width: 60%;">
                <div class="row align-items-start">
                    <div class="col">
                        Usuario:</br> <input type="text" placeholder="Usuario" name="Usuario"></br>
                        Contraseña:</br> <input type="text" placeholder="Contraseña" name="Contraseña"></br>
                        </br><input type="submit" value="Acceder" name="Acceder">
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

<?php
    require_once __DIR__ . "/../clases/Crud.php";
    $crud = new Crud();
    $datos = $crud->listarDatos();
?>