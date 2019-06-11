<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/Usuario.php';
    require_once __DIR__.'/include/Game.php';
    require_once __DIR__.'/include/search.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css"/>
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1 class="search-title">Search results for: <?php echo ''.$_GET['search']; ?></h1>
        <div>
            <?php
                if ($type == 'games' && $games) {
                    echo '<div class="multiple-items">';
                    $i = 1;
                    while($row = $games->fetch_assoc()) {
                        $game = Game::find($row['id']);
                        echo '<div class="home-game"><h1>#'.$i.'</h1>
                        '.$game->topTenString().'';
                        echo '<h3>Genres: '.$game->genresString().'</h3>';
                        echo '</div>';
                        $i++;
                    }
                    echo '</div>';
                } else if ($type == 'games') {
                    echo '<h2>No results</h2>';
                }
                if ($users) {
                    echo '<div class="multiple-items">';
                    while($row = $users->fetch_assoc()) {
                        echo '<div>';
                        $user = Usuario::buscaUsuarioId($row['id']);
                        echo ''.$user->profileImage(); // Me devuelve la imagen de perfil del usuario
                        echo '<h1><a href="userProfile.php?id='.$user->id().'">'.$user->username().'</a></h1>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else if ($type == 'users') {
                    echo '<h2>No results</h2>';
                }
            ?>
        </div>
    </div>
    <?php 
        require('include/comun/footer.php');
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