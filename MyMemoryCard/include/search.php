<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';

    $search = $_GET['search'];
    $type = $_GET['type'];
    $users = "";
    $games = "";

    if ($type === "users") {

        // Get all users that start with the 3 first characters of search
        $sql = 'SELECT * FROM users WHERE username LIKE \''.$search.'%\''; // Return owner id
        $result = $conn->query($sql);
        if ($result->num_rows > 0) $users = $result;

    } else if ($type === "games") {

         // Get all games that start with the 3 first characters of search
         $sql = 'SELECT * FROM games WHERE title LIKE \''.$search.'%\''; // Return owner id
         $result = $conn->query($sql);
         if ($result->num_rows > 0) $games = $result;

    } else {
        header('Location: error.php');
    }
    
?>