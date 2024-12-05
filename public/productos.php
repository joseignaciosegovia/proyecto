<?php
    // Cargamos la cabecera
    require_once "../vista/header.php";
?>
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
                        require_once __DIR__ . "/../controlador/Crud.php";

                        $crud = new Crud();
                        $producto = $crud->obtenerDatos("productos", ["nombre" => $_GET['producto']], []);
                        
                    ?>
                        <img class="imagenProducto" src="../img/<?php echo $producto->imagen ?>" alt="" class="product-img">
                        <h2 class="product-title"><?php echo $producto->nombre ?></h2>
                        <p class="product-description"><?php echo $producto->descripcion ?></p>
                        <span class="product-price"><?php echo $producto->precio_actual ?>€</span><br>
                        
                        <button class="btn btn-primary productbtn add-cart styleaddcartproduct">Añadir Al Carrito</button>
                </div>
            </div>
        </div>
            
        </div>
        <?php
            // Cargamos el pie
            require_once "../vista/footer.php";
        ?>
    </body>
</html>