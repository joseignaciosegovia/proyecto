<?php
    session_start();
    function error($mensaje) {
        $_SESSION['error'] = $mensaje;
        header('Location:registroUsuario.php');
        die();
    }
?>

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
        /*spl_autoload_register(function ($class) {
            require "/../clases/" . $class . ".php";
        });*/

        require_once __DIR__ . "/../clases/Cliente.php";
        require_once __DIR__ . "/../clases/Conexion.inc.php";
        require_once __DIR__ . "/../clases/Crud.php";

        /*$cliente = new Cliente("usuario", "contraseña", "nombre", "direccion", "ciudad", "email@hotmail.com", 66);
        $cliente->compras = "";
        $cliente->deseos = "";
        $cliente->quejas = "";

        $prueba = new Prueba("nombre");
        $prueba->nombre = "nombre";

        $pruebaJSON = json_encode($prueba);

        echo $cliente->nombre;

        $jsonCliente = json_encode($array);

        echo $jsonCliente;
        echo "</br>";*/

        function nombreNoVacio(&$nombre) {
            // Comprobamos que el nombre no esté vacío
            if (strlen($nombre) == 0) {
                error("Error el Nombre no puede estar en blanco");
            }

            // Ponemos la primera letra de cada palabra en mayúsculas
            $nombre = ucwords($nombre); 
        }

        function usuarioNoRepetido($usuario, $crud) {
            $crud->listarDatos("clientes", "{usuario:$usuario}");
        }
        
        if (isset($_POST['enviar'])) {
            $crud = new Crud();

            // Recogemos los datos del formulario
            // Trimamos las cadenas
            $nombre = trim($_POST['nombre']);
            $trabajador = trim($_POST['usuario']);
            $contraseña = trim($_POST['contraseña']);
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];

            nombreNoVacio($nombre);

            $respuesta = $crud->obtenerDatos("clientes", ["usuario" => $trabajador], ["usuario" => true]);
            if($respuesta != null) {
                error("El usuario está repetido");
            }
            
            $cliente = new Cliente($trabajador, $contraseña, $nombre, $direccion, $ciudad, $email, $telefono);

            $arrayCliente = [
                "usuario" => $cliente->usuario,
                "nombreCompleto" => $cliente->nombreCompleto,
                "direccion" => $cliente->direccion,
                "ciudad" => $cliente->ciudad,
                "email" => $cliente->email,
                "telefono" => $cliente->telefono,
                "compras" => "",
                "deseos" => "",
                "quejas" => "",
                "_id" => new MongoDB\BSON\ObjectId()
            ];

            $resultado = $crud->añadirDatos("clientes", $arrayCliente, []);

            $arrayContraseñaCliente = [
                "cliente_id" => $arrayCliente['_id'],
                "usuario" => $cliente->usuario,
                "contraseña" => $cliente->contraseña
            ];

            $crud->añadirDatos("contraseñasClientes", $arrayContraseñaCliente, []);
            
            $_SESSION['mensaje'] = 'Cliente creado Correctamente';

            // MOSTRAR MENSAJE DE USUARIO CREADO CORRECTAMENTE

            header('Location:../index.html');
        } else {
    ?>
        <form name="crear" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nom">Nombre Completo</label>
                    <input type="text" class="form-control" id="nom" placeholder="Nombre Completo" name="nombre" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="usu">Nombre de usuario</label>
                    <input type="text" class="form-control" id="usu" placeholder="Nombre de usuario" name="usuario" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="con">Contraseña</label>
                    <input type="password" class="form-control" id="con" placeholder="Contraseña" name="contraseña" required>
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
        </form>
        <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='mt-3 text-danger font-weight-bold text-lg'>";
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                echo "</div>";
            }
        ?>
        <?php } ?>
    </body>
</html>