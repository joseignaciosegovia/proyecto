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

<?php
    // Cargamos la cabecera
    require_once "../vista/header.php";
?>
        </header>

        <div id="usuario">
            <h2 class="usuario-titulo">Usuario</h2>
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
        <?php
            // Cargamos el pie
            require_once "../vista/footer.php";
        ?>
        <script type="module" src="../js/seccionesCliente.js"></script>
    </body>
</html>