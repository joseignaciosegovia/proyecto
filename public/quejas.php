<?php
    session_start();

    require_once "../controlador/Crud.php";

    $crud = new Crud();

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION['cliente'])) {
        header("Location: ../index.php");
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
        <?php
            // Cargamos el pie
            require_once "../vista/footer.php";
        ?>
        <script type="module" src="../js/perfilYQuejas.js"></script>
    </body>
</html>