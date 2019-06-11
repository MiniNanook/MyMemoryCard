<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/loadUserGames.php'; // Carga el usuario del cual vamos a ver la información
?>
<!DOCTYPE html>
<html>
<head>
	<title>Game List</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
	<?php
		require("include/comun/header.php");
    ?>
    
    <div class="content">
        <div class="game-list-title">
            <?php
                if ($user->username() == $_SESSION['user']->username()) echo '<h1>Your Game List</h1>'; // Tu perfil - Puedes cambiar las notas etc
                else echo '<h1>'.$user->username().'\'s Game List</h1>'; // Perfil de otro usuario
                if (!$games) {
                    if ($user->username() == $_SESSION['user']->username()) echo '<h2>Your game list is empty! <a href="search.php">Browse our website!</a></h2>';
                    else echo '<h1>'.$user->username().'\'s game list is empty.</h1>'; // Perfil de otro usuario
                } else { // Imprime todos los juegos que tengas en tu lista
            ?>
        </div>
        <div class="list-tags">
            Order By:
            <ul>
                <li><a href="gameList.php?id=<?php echo ''.$id; ?>&order=score">Score</a></li>
                <li><a href="gameList.php?id=<?php echo ''.$id; ?>&order=title">Title</a></li>
                <li><a href="gameList.php?id=<?php echo ''.$id; ?>&order=favourites">Favourites</a></li>
                <li><a href="gameList.php?id=<?php echo ''.$id; ?>&order=status">Status</a></li>
            </ul>
        </div>

        <?php
            echo '<table>
                    <tr>
                        <th><a href="gameList.php?id='.$id.'&order=title">Game</a></th>
                        <th><a href="gameList.php?id='.$id.'&order=score">Score</a></th>
                        <th><a href="gameList.php?id='.$id.'&order=status">Status</a></th>
                        <th><a href="gameList.php?id='.$id.'&order=favourites">Favourite</a></th>
                        <th></th>
                    </tr>';
            while($row = $games->fetch_assoc()) {
                $game = Game::find($row['gameId']);
                echo '<tr>
                        <td><a href="gamePage.php?id='.$game->id().'">'.$game->title().'</a></td>
                        <td>'.$row['rating'].'/10</td>
                        <td>'.$row['status'].'</td>';
                        if ($row['isFavourite'] == 1) echo '<td>Yes</td>';
                        else echo '<td>No</td>';
                        if ($user->username() == $_SESSION['user']->username()) echo '<td><a href="deleteGame.php">Delete</a></td>
                    </tr>';
            }
            echo '</table>';
        }
		?>
    </div>
    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>