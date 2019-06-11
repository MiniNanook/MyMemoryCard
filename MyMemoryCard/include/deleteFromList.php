<?php
    require_once __DIR__.'/Game.php';
    require_once __DIR__.'/config.php';

    $game = Game::find($_POST['id']); // El juego que voy a añadir a mi lista
    $me = $_SESSION['user']; // Yo

    $delete = $me->deleteGame($game); //  Función para añadir el juego a mi lista

    if ($delete) header('Location: ../gamePage.php?id='.$game->id().'');
    else header('Location: ../error.php');

?>