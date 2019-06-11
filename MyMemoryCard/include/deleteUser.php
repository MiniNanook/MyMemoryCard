<?php

require_once __DIR__.'/Usuario.php';
require_once __DIR__.'/config.php';

if (!Usuario::delete($_POST['id'])) {
    echo 'User could not be deleted!';
    exit();
} else {
    header('Location: ../adminSettings.php');
}

?>