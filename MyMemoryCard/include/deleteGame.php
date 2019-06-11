<?php

require_once __DIR__.'/Game.php';
require_once __DIR__.'/config.php';

if (!Game::delete($_POST['id'])) {
    echo 'Game could not be deleted!';
    exit();
} else {
    header('Location: ../adminSettings.php');
}

?>