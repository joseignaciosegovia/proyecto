<?php
    // Cargamos la cabecera
    require_once "vista/header.php";
?>
            <div class="btn-group">
                <button>Novedades</button>
                <button>Ofertas</button>
                <button>Ordenadores</button>
                <button>Componentes</button>
            </div>
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
        <div id="novedades">
            
        </div>
        <div id="ofertas">
            
        </div>
        <div id="ordenadores">
            
        </div>
        <div id="componentes">
            
        </div>

        <?php
            // Cargamos el pie
            require_once "vista/footer.php";
        ?>
        <script type="module" src="js/main.js"></script>
    </body>
</html>