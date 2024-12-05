<?php
    session_start();

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        header("Location: http://localhost/Aplicacion/index.php");
        exit();
    }

    // Cerramos la sesión con el cliente
    unset($_SESSION['cliente']);
    // Al acceder a la página directamente, cerramos sesión y volvemos a la página de inicio
    header("Location: http://localhost/Aplicacion/index.php");
    exit();