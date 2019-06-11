<?php

    $id = $_GET['id'];
    $user = Usuario::buscaUsuarioId($id);
    $me = false;
    if ($id == $_SESSION['user']->id()) $me = true;
    $amigos = $user->amigos(); // Devuelve la lista de amigos
    
?>