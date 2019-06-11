<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/loadMessages.php'; // Carga el usuario del cual vamos a ver la información
?>
<!DOCTYPE html>
<html>
<head>
	<title>Messages</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
	<?php
		require("include/comun/header.php");
    ?>
    
    <div class="content">
        <div class="messages title">
            <h1>My messages</h1>
        </div>
        <?php
        if ($messages) {
            while($row = $messages->fetch_assoc()) {
                echo '<div class="message">';
                    $sender = Usuario::buscaUsuarioId($row['idSender']);
                    echo '<h2 id="title"> Message from: <a href="userProfile.php?id='.$sender->id().'">'.$sender->username().'</a></h2>';
                    // Botón de Aceptar | Rechazar
                    echo '<h2 id="concept">Title: '.$row['title'].'</h2>';
                    echo '<h3 id="text">Message: '.$row['message'].'</h3>';
                echo '</div>';
            }
        } else {
            echo '<h2>No messages</h2>';
        }
        ?>
    </div>
    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>