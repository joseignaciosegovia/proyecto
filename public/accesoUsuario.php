<?php
session_start();

require_once __DIR__ . "/../clases/Cliente.php";
require_once __DIR__ . "/../clases/Conexion.inc.php";

//Hacemos el autoload de las clases
/*spl_autoload_register(function ($class) {
    require "clases/" . $class . ".php";
});*/
function error($mensaje) {
    $_SESSION['error'] = $mensaje;
    header('Location:accesoUsuario.php');
    die();
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
            integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Login</title>
    </head>

    <body style="background:silver;">
    <?php
        if (isset($_POST['login'])) {
            $nombre = trim($_POST['usuario']);
            $contraseña = trim($_POST['pass']);
            if (strlen($nombre) == 0 || strlen($contraseña) == 0) {
                error("Error, El nombre o la contraseña no pueden contener solo espacios en blancos.");
            }

            // Comprobamos si existe un cliente con el usuario y la contraseña introducidos
            $cliente = Cliente::isValido($nombre, $contraseña);
            // Si no existe, mostramos el error y actualizamos la página
            if ($cliente == null) {
                error("Credenciales Inválidas");
            }

            $_SESSION['cliente'] = $nombre;

            // MOSTRAR UN MENSAJE DE LOGEO CORRECTO Y QUE EL USUARIO PUEDA ACCEDER A SU INFORMACIÓN

            header('Location:../index.html');
        } else {
            ?>
            <div class="container mt-5">
                <div class="d-flex justify-content-center h-100">
                    <div class="card">
                        <div class="card-header">
                            <h3>Iniciar sesión</h3>
                            <h4>¿No tienes cuenta? <a href="registroUsuario.php">Regístrate aquí</a></h4>
                        </div>
                        <div class="card-body">
                            <form name='login' method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="usuario" name='usuario' required>

                                </div>
                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="contraseña" name='pass' required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Login" class="btn float-right btn-success" name='login'>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                if (isset($_SESSION['error'])) {
                    echo "<div class='mt-3 text-danger font-weight-bold text-lg'>";
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    echo "</div>";
                }
            ?>
        </div>
        <?php } ?>
    </body>
</html>