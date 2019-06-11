<?php
    require_once __DIR__.'/include/Aplicacion.php';
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/adminSetup.php'; // Script encargado de inicializar todos los parámetros necesarios para las opciones del administrador
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Settings</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css"/>
</head>
<body>
	<?php
		require("include/comun/header.php");
    ?>
    
    <div class="content">
        <div class="buscador-admin">
            <h1 id="admin-title">Admin Settings</h1>
            <h2 id="admin-search">Search for any User/Game
            <form method="POST" action="adminSettings.php">
                <input type="text" id="search" name="search" placeholder="Search...">
                <input type="hidden" id="parse" name="parse">
                <button type="submit" class="go" value="search"><i class="fa fa-search"></i></button>
            </form>
            </h2>
        </div>
        <div class="admin-usuarios">
            <?php
                echo '<h1>All Users</h1>';
                echo '<div class="multiple-items">';
                if ($allUsers) {
                    while($row = $allUsers->fetch_assoc()) {
                        echo '<div>';
                        $user = Usuario::buscaUsuarioId($row['id']);
                        echo ''.$user->profileImage(); // Me devuelve la imagen de perfil del usuario
                        echo '<h1><a href="userProfile.php?id='.$user->id().'">'.$user->username().'</a></h1>';
                        echo '<form method="POST" action="include/deleteUser.php">';
                            echo '<input type="hidden" value="'.$user->id().'" name="id">';
                            echo '<input type="submit" value="Delete User">';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo '<h1>No results.</h1>';
                }
                echo '</div>';
            ?>
        </div>
        <div class="admin-juegos">
            <?php
                echo '<h1>All Games</h1>';
                echo '<div class="multiple-items">';
                if ($allGames) {
                    while($row = $allGames->fetch_assoc()) {
                        $game = Game::find($row['id']);
                        echo '<div class="home-game">
                        '.$game->topTenString().'';
                        echo '<h3>Genres: '.$game->genresString().'</h3>';
                        echo '<form method="POST" action="include/deleteGame.php">';
                            echo '<input type="hidden" value="'.$game->id().'" name="id">';
                            echo '<input type="submit" value="Delete Game">';
                        echo '</form>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            ?>
        </div>
    </div>

    <?php
		require("include/comun/footer.php");
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.multiple-items').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                autoplay: true,
                autoplaySpeed: 3000,
                dots: true,
                speed: 700,
                arrows: true
            });
        });
    </script>
</body>
</html>