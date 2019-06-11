<?php
    require_once __DIR__.'/Game.php';
    require_once __DIR__.'/config.php';

    $game = Game::find($_POST['game']); // El juego que voy a añadir a mi lista
    $me = $_SESSION['user']; // Yo
    $score = $_POST['score'];
    $fav = false;
    $status = $_POST['status'];
    if (isset($_POST['favourite'])) $fav = true;

    $add = $me->addGame($game, $score, $status, $fav); //  Función para añadir el juego a mi lista

    if ($add) header('Location: ../gameList.php?id='.$me->id().'');
    else header('Location: ../error.php');

?>