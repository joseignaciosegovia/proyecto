<?php
    session_start();

    //Hacemos el autoload de las clases
    spl_autoload_register(function ($class) {
        require "../clases/" . $class . ".php";
    });

    function error($mensaje) {
        $_SESSION['error'] = $mensaje;
        header('Location:perfil.php');
        die();
    }

    $crud = new Crud();

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        header("Location: ../index.html");
        exit();
    }

    // Si pulsamos el botón de actualizar perfil
    if (isset($_POST['Actualizar'])) {
        // Si se ha cambiado el nombre de usuario y coincide con uno ya existente
        if($_SESSION["cliente"] != $_POST['Usuario'] && $crud->obtenerDatos("clientes", ["usuario" => $_POST['Usuario']], [])){
            error("Error, El nombre de usuario ya existe.");
        }

        $cliente = [
            "nombreCompleto" => $_POST['Nombre'],
            "usuario" => $_POST['Usuario'],
            "telefono" => $_POST['Telefono'],
            "direccion" => $_POST['Direccion'],
            "localidad" => $_POST['Localidad']
        ];

        // Actualizamos el perfil en la base de datos
        $crud->actualizarDatos("clientes", ["usuario" => $cliente['usuario']], $cliente);

        // Ventana que indica que el perfil se ha actualizado correctamente
        echo "<dialog open>
              <p>El perfil se ha actualizado correctamente</p>
            <button onclick=\"this.parentElement.close()\">OK</button>
        </dialog>";
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Perfil Usuario</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Animanate CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    </head>
    <body>
        <header>
            <div id="cabecera">
                <h1><a href="../index.html">ELECTRÓNICA ONLINE</a></h1>
                <div id="iconosCabecera">
                    <a><i class="bi bi-cart-dash"></i></a>
                    <a><i class="bi bi-search"></i></a>
                    <a><i class="bi bi-person-circle"></i></a>
                </div>
            </div>
        </header>

        <div id="usuario">
            <h2 class="cart-title">Usuario</h2>
            <button type="button" class="btn-trabajadores">Acceso a trabajadores</button>
            <button type="button" class="btn-usu">Acceso a usuarios</button>
            <button type="button" class="btn-login">Registrarse</button>
            <i class="bi bi-x-circle" id="cerrarUsuario"></i>
        </div>

        <div class="cart" id="cesta">
            <h2 class="cart-title">Cesta</h2>
            <div class="cart-content">

            </div>

            <div class="total">
                <div class="total-title">Total</div>
                <div class="total-price">0€</div>
            </div>

            <button type="button" class="btn-buy">Comprar</button>
            <i class="bi bi-x-circle" id="cerrarCesta"></i>
        </div>

        <div>
        <div class="row">
            <?php 
                $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);
            ?>
            
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <span class="font-weight-bold"><?php echo $cliente->usuario ?></span>
                    <span class="text-black-50"><?php echo $cliente->email ?></span>
                    <span></span>
                </div>
            </div>
            
            <div class="col-md-5 border-right">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Perfil</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombre" name="Nombre" value="<?php echo $cliente->nombreCompleto ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Usuario</label>
                                <input type="text" class="form-control" placeholder="Usuario" name="Usuario" value="<?php echo $cliente->usuario ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Teléfono</label>
                                <input type="text" class="form-control" placeholder="Teléfono" name="Telefono" value="<?php echo $cliente->telefono ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Dirección</label>
                                <input type="text" class="form-control" placeholder="Dirección" name="Direccion" value="<?php echo $cliente->direccion ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Localidad</label>
                                <input type="text" class="form-control" placeholder="Localidad" name="Localidad" value="<?php echo $cliente->localidad ?>">
                            </div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" name="Actualizar">Actualizar perfil</button></div>
                    </div>
                </div>
                <?php
                    // Si hay algún error lo mostramos aquí
                    if (isset($_SESSION['error'])) {
                        echo "<div class='mt-3 text-danger font-weight-bold text-lg'>";
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        echo "</div>";
                    }
                ?>
            </form>
        </div>
        <div id="seccionEntrega">
            <div id="entrega">
                <i class="bi bi-box-fill"></i>
                <p>Entrega a domicilio</p>
            </div>
            <div id="envio">
                <i class="bi bi-truck"></i>
                <p>Envíos gratis desde 50€</p>    
            </div>
            <div id="devoluciones">
                <i class="bi bi-arrow-return-left"></i>
                <p>Devoluciones en 14 días</p>    
            </div>
        </div>
        <footer>
            <div id="contacto">
                <div id="enlacesContacto">
                    <a>Contacto</a>
                    <a>Sobre nosotros</a>
                    <a>Aviso legal</a>
                    <a>Política de privacidad</a>
                    <a>Ajustes de Cookies</a>
                </div>
                <div id="iconosContacto">
                    <a href="https://x.com/"><i class="bi bi-twitter-x"></i></a>
                    <a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a>
                    <a href="https://facebook.com/"><i class="bi bi-facebook"></i></a>
                </div>
            </div>
            <div id="copyright">
                <a href="https://www.paypal.com/"><i class="bi bi-paypal"></i></a>
                <a>© Copyright 2024, Electrónica Online</a>
            </div>
        </footer>
        <script src="../js/perfilYQuejas.js"></script>
        
    </body>
</html>