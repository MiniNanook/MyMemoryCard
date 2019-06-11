<?php

    $id = $_GET['id'];
    $user = Usuario::buscaUsuarioId($id);
    if (!$user) header('Location: ../error.php');

    $tags = "none";
    if (isset($_GET['order'])) $tags = $_GET['order'];

    $games = $user->getGameList($tags); // Lista de Juegos (ordenado como quiera el usuario) o False si no tiene ninguno 

?>