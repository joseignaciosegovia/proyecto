<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Electrónica online</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Animanate CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <!--<link rel="stylesheet" type="text/css" href="../css/estilos.css">-->
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

        <div class="shop container"><br><br>
            <div class="product-box">
                <div class="product-info">
                    <?php
                        //Hacemos el autoload de las clases
                        spl_autoload_register(function ($class) {
                            require "../clases/" . $class . ".php";
                        });

                        $crud = new Crud();
                        $producto = $crud->obtenerDatos("productos", ["nombre" => $_GET['producto']], []);
                        
                    ?>
                        <img src="../img/<?php echo $producto->imagen ?>" alt="" class="product-img">
                        <h2 class="product-title"><?php echo $producto->nombre ?></h2>
                        <p class="product-description"><?php echo $producto->descripcion ?></p>
                        <span class="product-price"><?php echo $producto->precio ?></span><br>
                        
                        <button class="btn btn-primary productbtn add-cart styleaddcartproduct">Añadir Al Carrito</button>
                </div>
            </div>
        </div>
            
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
        <!-- <script src="../js/main.js"></script> -->
    </body>
</html>