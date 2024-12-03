<?php
    session_start();

    // Si no hemos iniciado sesión como cliente, volvemos a la página de inicio
    if (empty($_SESSION["cliente"])) {
        header("Location: http://localhost/Aplicacion/index.php");
        exit();
    }

    unset($_SESSION['cliente']);
    header("Location: http://localhost/Aplicacion/index.php");
    exit();