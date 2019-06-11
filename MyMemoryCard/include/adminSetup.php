<?php
    // Este script carga en variables todo lo necesario para manejar datos dentro del sistema

    if (!$_SESSION['isAdmin']) { // Solo deja entrar aquí a usuarios con derechos de administrador
        header('Location: ../error.php');
    }

    $allUsers = false;
    $allGames = false;

    if (isset($_POST['parse'])) { // El admin ha hecho una búsqueda, en vez de querer todos los usuarios y juegos
        $allUsers = Usuario::dumpUsersParsed($_SESSION['user'], $_POST['search']);
        $allGames = Game::dumpGamesParsed($_SESSION['user'], $_POST['search'] );
    } else {
        $allUsers = Usuario::dumpUsers($_SESSION['user']); // Esta función, solo disponible para el/los admin de la página, me devuelve todos los usuarios de la base de datos
        $allGames = Game::dumpGames($_SESSION['user']); // Devuelve todos los juegos de la base de datos
    }    

?>