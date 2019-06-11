<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/loadFriends.php'; // Carga el usuario del cual vamos a ver la información
?>
<!DOCTYPE html>
<html>
<head>
	<title>Friend List</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/friends.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css"/>
</head>
<body>
	<?php
		require("include/comun/header.php");
    ?>
    <div class="content">
        <h1 class="friends-title">Friend List</h1>
        <?php
        if (!$amigos) {
                if ($me) {
                    echo '<h2>You don\'t have any friends! :(</h2>';
                } else {
                    echo '<h2>'.$user->username().' doesn\'t have any friends! :(</h2>';
                }
            }
        ?>
        <div class="multiple-items">
        <?php
            while($row = $amigos->fetch_assoc()) {
                echo '<div>';
                    $amigo = "";
                    if ($row['idFriendA'] == $id) { // Si este usuario, está en la columna A de la lista (soy yo)
                        $amigo = Usuario::buscaUsuarioId($row['idFriendB']);
                    } else { // Estoy en la otra columna
                        $amigo = Usuario::buscaUsuarioId($row['idFriendA']);
                    }
                    echo ''.$amigo->profileImage(); // Me devuelve la imagen de perfil del usuario
                    echo '<h1><a href="userProfile.php?id='.$amigo->id().'">'.$amigo->username().'</a></h1>';
                echo '</div>';
            }
        ?>
        </div>
    </div>
    <?php
		require("include/comun/footer.php");
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
    <!-- La razón por la que aquí no incluyo un JS es por que cada página tendrá unos settings distintos. -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('.multiple-items').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 4,
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