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

    if(isset($_POST['Actualizar'])){
        foreach($_POST as $clave => $valor) {
            if($clave != "Actualizar" && $clave != "Productos"){

            }
        }
        
    }
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
            <?php 
                $cliente = $crud->obtenerDatos("clientes", ["usuario" => $_SESSION['cliente']], []);
                if($cliente->deseos->count() > 0){

            ?> 
            <div class="col-md-6">
                <h2>Lista de deseos</h2>
                <form method="POST">
                    <table class="table table-hover">
                        <thead>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Fecha en que se añadió</th>
                            <th>Eliminar de la lista</th>
                        </thead>
                        <tbody>
                            <?php
                                foreach($cliente->deseos as $deseo) {
                                    echo "<tr>";
                                    echo "<td><a href=\"../public/productos.php?producto=$deseo->nombre\">$deseo->nombre</a></td>";
                                    echo "<td>$deseo->precio</td>";
                                    echo "<td>$deseo->fecha</td>";
                                    echo "<td><input type='checkbox' name='productos[]' value='" . $deseo->nombre . "'/></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody> 
                        
                    </table>
                    <input type="submit" value="Actualizar" name="Actualizar">
                </form>
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
        <script type="module" src="/Aplicacion/js/seccionesCliente.js"></script>
    </body>
</html>