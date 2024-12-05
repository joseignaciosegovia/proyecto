<?php
    session_start();

    require_once "../controlador/Crud.php";

    function error($mensaje) {
        $_SESSION['error'] = $mensaje;
        header('Location:perfil.php');
        die();
    }

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        header("Location: ../index.php");
        exit();
    }

    $crud = new Crud();
    $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);
    if($cliente->compras->count() > 0){

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

        <div class="cesta" id="cesta">
            <h2 class="cesta-titulo">Cesta</h2>
            <div class="contenido-cesta">

            </div>

            <div class="total">
                <div class="titulo-total">Total</div>
                <div class="precio-total">0€</div>
            </div>

            <button type="button" class="btn-comprar">Comprar</button>
            <i class="bi bi-x-circle" id="cerrar-cesta"></i>
        </div>

        <div>
        <div class="row">
            
            <div class="col-md-6">
                <h2>Historial de compras</h2>
                <table class="table table-hover">
                    <thead>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Fecha en que se compró</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($cliente->compras as $deseo) {
                                echo "<tr>";
                                echo "<td><a href=\"../public/productos.php?producto=$deseo->nombre\">$deseo->nombre</a></td>";
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
                ?>
                    <dialog open>
                        <p>No ha comprado ningún producto hasta el momento</p>
                        <button onclick="<?php header("Location: ../index.php") ?>">OK</button>
                    </dialog>
                <?php
                    //header("Location: ../index.php");
                    //exit();
                }
            // Cargamos el pie
            require_once "../vista/footer.php";
        ?>
        <script type="module" src="/Aplicacion/js/seccionesCliente.js"></script>
    </body>
</html>