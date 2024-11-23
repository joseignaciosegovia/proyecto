<?php
    session_start();
    // Si no hemos iniciado sesión como trabajador, volvemos a la página de inicio de sesión de los trabajadores
    if (empty($_SESSION["trabajador"])) {
        header("Location: servidor.php");
        exit();
    }

    switch ($_SESSION['departamento']) {
        case 'Compras':
            echo "Departamento de compras";
            breaK;
        case 'Análisis':
            echo "Departamento de análisis";
            breaK;
        case 'Gestión':
            echo "Departamento de gestión";
            breaK;
        case 'Servicio Técnico':
            echo "Departamento de servicio técnico";
            breaK;
    }
?>