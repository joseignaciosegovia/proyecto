<?php
    session_start();

    //Hacemos el autoload de las clases
    spl_autoload_register(function ($class) {
        require "../clases/" . $class . ".php";
    });

    $crud = new Crud();

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        header("Location: ../index.html");
        exit();
    }

    // Si pulsamos el botón de "Enviar"
    if (isset($_POST['Enviar'])) {

        $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);
        // Añadimos la nueva queja/sugerencia al final del array de quejas/sugerencias
        $cliente->quejas[] = ["descripcion" => $_POST['Queja'], "fecha" => date('Y-m-d h:i:s a', time())];

        // Añadimos la queja/sugerencia al perfil del usuario en la base de datos
        $crud->actualizarDatos("clientes", ["usuario" => $_SESSION['cliente']], ["quejas" => $cliente->quejas]);

        // Ventana que indica que el perfil se ha actualizado correctamente
        echo "<dialog open>
              <p>La queja o sugerencia se ha realizado correctamente</p>
            <button onclick=\"this.parentElement.close()\">OK</button>
        </dialog>";
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Quejas y sugerencias del Usuario</title>
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
            <div class="col-md-5 border-right">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Quejas y sugerencias</h4>
                        </div>
                        <div>
                            <div>
                                <label class="labels">Queja o sugerencia</label>
                                <textarea class="form-control" placeholder="" name="Queja" value="" rows="5" cols="100"></textarea>
                            </div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" name="Enviar">Realizar queja/sugerencia</button></div>
                    </div>
                </div>
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
        <script src="../js/main.js"></script>
    </body>
</html>