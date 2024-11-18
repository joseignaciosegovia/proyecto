<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- css para usar Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
            integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Crear</title>
    </head>
    <body>
    <?php
        if (isset($_POST['enviar'])) {
            //recogemos los datos del formulario, trimamos las cadenas
            $nombre = trim($_POST['nombre']);
            $usuario = trim($_POST['usuario']);
            $direccion = $_POST['direccion'];
            $des = trim($_POST['descripcion']);
            $ciudad = $_POST['ciudad'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            comprobar($nombre, $usuario);
            // si hemos llegado aqui todo ha ido bien vamos a crear el registro
            $producto->setNombre($nombre);
            $producto->setNombre_corto($usuario);
            $producto->setPvp($direccion);
            $producto->setFamilia($ciudad);
            $producto->setDescripcion($des);
            $producto->create();
            $_SESSION['mensaje'] = 'Producto creado Correctamente';
            $producto = null;
            header('Location: listado.php');
        } else {
    ?>
        <form name="crear" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nom">Nombre Completo</label>
                    <input type="text" class="form-control" id="nom" placeholder="Nombre Completo" name="nombre" required>
                </div>
            </div>
            <div>
                <div class="form-group col-md-6">
                    <label for="usu">Nombre de usuario</label>
                    <input type="text" class="form-control" id="usu" placeholder="Nombre de usuario" name="usuario" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dir">Dirección</label>
                    <input type="text" class="form-control" id="dir" placeholder="Dirección" name="direccion" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ciu">Ciudad</label>
                    <input type="text" class="form-control" id="ciu" placeholder="Ciudad" name="ciudad" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ema">Email</label>
                    <input type="email" class="form-control" id="ema" placeholder="Email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tel">Teléfono</label>
                    <input type="tel" class="form-control" id="tel" placeholder="Teléfono" name="telefono" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-3" name="enviar">Crear</button>
            <input type="reset" value="Limpiar" class="btn btn-success mr-3">
            <a href="listado.php" class="btn btn-info">Volver</a>
        </form>
    </body>
    <?php } ?>
</html>