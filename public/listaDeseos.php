<?php
    session_start();

    require_once "../controlador/Crud.php";

    function error($mensaje) {
        $_SESSION['error'] = $mensaje;
        header('Location:perfil.php');
        die();
    }

    $crud = new Crud();

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        header("Location: ../index.php");
        exit();
    }

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

        <div>
        <div class="row">
            <?php 
                $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);
                if($cliente->deseos->count() > 0){

            ?> 
            <div class="col-md-6">
                <h2>Lista de deseos</h2>
                <table class="table table-hover">
                    <thead>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Fecha en que se añadió</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($cliente->deseos as $deseo) {
                                echo "<tr>";
                                echo "<td><a href=\"../productos/productos.php?producto=$deseo->nombre\">$deseo->nombre</a></td>";
                                echo "<td>$deseo->precio" ."€</td>";
                                echo "<td>$deseo->fecha</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody> 
                </table>
            </div>
            <?php 
                } 
                else{
                    // NO MUESTRA EL DIÁLOGO
                    echo "<dialog open>
                        <p>No ha comprado ningún producto hasta el momento</p>
                        <button>OK</button>
                    </dialog>";
                    header("Location: ../index.php");
                    exit();
                }
            // Cargamos el pie
            require_once "../vista/footer.php";
        ?>
        <script src="../js/perfilYQuejas.js"></script>
    </body>
</html>