<?php

    require_once "../modelo/Trabajador.php";

    session_start();

    function error($mensaje) {
        $_SESSION['error'] = $mensaje;
        header('Location:servidor.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
            integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Listado</title>
    </head>
    <body style="background-color:powderblue;">
        <?php
            if (isset($_POST['login'])) {
                $nombre = trim($_POST['usuario']);
                $contraseña = trim($_POST['pass']);
                if (strlen($nombre) == 0 || strlen($contraseña) == 0) {
                    error("Error, El nombre o la contraseña no pueden contener solo espacios en blancos.");
                }

                // Comprobamos si existe un trabajador con el usuario y la contraseña introducidos
                $trabajador = Trabajador::isValido($nombre, $contraseña);
                // Si no existe, mostramos el error y actualizamos la página
                if ($trabajador == null) {
                    error("Credenciales Inválidas");
                }
                $_SESSION['trabajador'] = $nombre;
                $_SESSION['departamento'] = $trabajador->departamento;

                // MOSTRAR UN MENSAJE DE LOGEO CORRECTO Y QUE EL USUARIO PUEDA ACCEDER A SU INFORMACIÓN

                header('Location:intranet.php');
            } else {
        ?>
        <h1 style="text-align:center;">Intranet</h1>
        <div class="container mt-5">
                <div class="d-flex justify-content-center h-100">
                    <div class="card">
                        <div class="card-header">
                            <h3>Iniciar sesión a la Intranet</h3>
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