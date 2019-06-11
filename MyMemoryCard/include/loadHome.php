<?php

    if (!isset($_SESSION['user'])) {
        header('Location: signup.php');
    }

    $user = $_SESSION['user'];

    // Top 10 Juegos

    $topTen = Game::topTen(); // Devuelve los 10 juegos con mayor puntuación de la base de datos
    if (!$topTen) {
        echo 'Your petition could not be processed...';
        exit();
    }

    // Juegos recomendados

    $myList = $user->getGameList("none"); //  Devuelve los juegos a los que has jugado
    $allTags = array(); // Conjunto de todos los géneros de juego en formato String
    $recommended = ""; // Conjunto de juegos recomendados para este usuario
    if ($myList != false) { // Si no tienes juegos en tu lista, no recomiendes juegos salvo los top 10 juegos de todos los tiempos
        while ($row = $myList->fetch_assoc()) { // Coge una lista de los géneros de los juegos a los que has jugado
            $game = Game::find($row['gameId']);
            $genres = $game->genres();
            while ($row = $genres->fetch_assoc()) {
                $allTags[] = $row['genre'];
            }
        }
        // Remueve el inicio del formato de $allTags ", ";
        $recommended = Game::recommend($allTags, $user->getGameList("none")); // Devuelve juegos recomendados a partir de una lista de géneros y mi lista de juegos
    }

    // Usuarios Recomendados
    // Esta función depende de los juegos que tienes en tu lista, así que solo te recomienda usuarios si has añadido juegos a tu lista.
    
    $friends = "";
    $myFavList = $user->getFavouriteGameList(); //  Devuelve 10 de tus juegos favoritos
    if ($myFavList != false) { // Si no tienes juegos en tu lista de favoritos, no te recomienda a nadie al que seguir
        // Recorre todos los usuarios, comrpueba si tiene algún juego en favorito que coincida con el tuyo, y si no es tu amigo ya, recomiéndaselo
        $friends = $user->recommend($myFavList); // Recomiéndame usuarios dada mi lista de favoritos
    }

?>