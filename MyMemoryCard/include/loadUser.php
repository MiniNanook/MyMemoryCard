<?php

    $id = $_GET['id'];
    $user = Usuario::buscaUsuarioId($id);
    $peticiones = false;
    $amigos = false;
    $pending = false;
    $messages = false;

    if (!$user) header('Location: ../error.php');

    if ($_SESSION['user']->id() == $id) { // Eres tú
        $peticiones = $user->cargaPeticiones(); // Carga las peticines de amistad pendientes
        $messages = $user->cargaMensajes();
    } else { // No eres tú
        $amigos = $user->esAmigo($_SESSION['user']->id()); // Comprueba si sois amigos
        $pending = $user->compruebaPeticion($_SESSION['user']->id()); // Comprueba si existe o no una petición de amistad hacia, o desde, este usuario
    }

?>