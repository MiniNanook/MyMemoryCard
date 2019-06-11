<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/loadHome.php';

    if (!isset($_SESSION['login']) && !$_SESSION['login'] === true) {
        header("Location: signup.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">       
        <div class="search-bar" id="left">
            <h1>Search for a Videogame</h1>
            <p>Here you will be able to browse all of our website's added videogames.</p>
            <form method="GET" action="searchResult.php">
                <input type="hidden" id="type" name="type" value="games">
                <input type="text" id="search" name="search" placeholder="Search..." required>
                <button type="submit" class="go" value="search"><i class="fa fa-search"></i></button>
            </form>
        </div>
        
        <div class="search-bar" id="right">
            <h1>Search for other Gamers</h1>
            <p>Here you will be able to browse all of our website's users.</p>
            <form method="GET" action="searchResult.php">
                <input type="hidden" id="type" name="type" value="users">
                <input type="text" id="search" name="search" placeholder="Search..." required>
                <button type="submit" class="go" value="search"><i class="fa fa-search"></i></button>
            </form>
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
                    '.$game->topTenString().'
                    </div>';
                    $i++;
                }
            } else {
                echo '<div class="multiple-items">';
                echo '<p class="center"><h2>Add some games to your list to get some recommendations!</h2></p>';
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