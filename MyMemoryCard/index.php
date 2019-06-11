<?php
require_once __DIR__ . '/include/Usuario.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/loadHome.php';
if (!isset($_SESSION['login']) && !$_SESSION['login'] === true) {
    header("Location: signup.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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
        
        <!-- Top 10 -->
        <div class="home-title">
            <h1>Top 10 Games of All Time</h1>
            <h4>The players have spoken...</h4>
        </div>
        <div class="multiple-items">
        <?php
            if ($topTen) {
                $i = 1;
                while($row = $topTen->fetch_assoc()) {
                    $game = Game::find($row['id']);
                    echo '<div class="home-game"><h1>#'.$i.'</h1>
                    '.$game->topTenString().'
                    </div>';
                    $i++;
                }
            } else {
                echo '<p class="center"><h2>No games to be shown :(</h2></p>';
            }
        ?>
        </div>

        <!-- You Should Play -->
        <div class="home-title">
            <h1>You should play...</h1>
            <h4>Based on games you've already played</h4>
        </div>
        <?php
            if ($recommended) {
                echo '<div class="multiple-items">';
                $i = 1;
                while($row = $recommended->fetch_assoc()) {
                    $game = Game::find($row['id']);
                    echo '<div class="home-game"><h1>#'.$i.'</h1>
                    '.$game->topTenString().'';
                    echo '<h3>Genres: '.$game->genresString().'</h3>';
                    echo '</div>';
                    $i++;
                }
            } else {
                echo '<div class="multiple-items">';
                echo '<p class="center"><h2>Add some games to your list to get some recommendations!</h2></p>';
            }
        ?>
        </div>

        <!-- You Should Add Friends -->
        
        <div class="home-title">
            <h1>You should be friends with...</h1>
            <h4>It's dangerous to go alone!</h4>
        </div>
        <div class="multiple-items">
        <?php
            if ($friends) {
                foreach($friends as &$id) {
                    echo '<div>';
                    $user = Usuario::buscaUsuarioId($id);
                    echo ''.$user->profileImage(); // Me devuelve la imagen de perfil del usuario
                    echo '<h1><a href="userProfile.php?id='.$user->id().'">'.$user->username().'</a></h1>';
                    echo '</div>';
                }
            } else {
                echo '<p class="center"><h2>Add some games to your favourites so we can suggest new friends!</h2></p>';
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