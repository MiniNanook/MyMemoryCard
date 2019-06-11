<?php

    require_once __DIR__.'/Usuario.php';
    require_once __DIR__.'/Game.php';
    require_once __DIR__.'/config.php';


    $gameId = $_GET['id']; // Coge el ID del juego vía GET
    $user = $_SESSION['user'];
    $game = Game::find($gameId);

    if (!$game) header('Location: error.php'); // El juego que buscas no existe (ID no encontrada)

    $me = $_SESSION['user']; // Yo
    $listed = $me->findGame($game); // Comprueba si el juego está o no en mi lista
    $reviewed = $me->findReview($game); // Comrpueba si ya has escrito una reseña del juego

    $allReviews = $game->getReviews(); // Devuelve todas las reviews (menos la tuya) que hay de este juego (si es que hay alguna), sino false
?>