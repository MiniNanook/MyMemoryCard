<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/loadUser.php'; // Carga el usuario del cual vamos a ver la información
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
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
		<?php // Es caso de que hayamos llegado aquí después de pedir añadir a un amigo
            if (isset($_GET['result'])) {
                switch ($_GET['result']) {
                    case "addOk":
                        echo "<script> window.onload = function() {
                            alert('Petición de amistad enviada correctamente.');
                    }; </script>";
                    break;
                    case "acceptOk":
                    echo "<script> window.onload = function() {
                        alert('Ahora sois amigos!');
                }; </script>";
                    break;

                    case "declineOk":
                    echo "<script> window.onload = function() {
                        alert('Petición de amistad rechazada.');
                }; </script>";
                    break;
                    case "deleteOk":
                    echo "<script> window.onload = function() {
                        alert('Ya no sois amigos :(.');
                }; </script>";
                    break;

                    default:
                    echo "<script> window.onload = function() {
                        alert('Algo ha ido mal...');
                }; </script>";
                    break;
                }
            }
        ?>

        <div class="profile">
            <!-- Left Side -->

            <div class="profile-left">
                <?php
                    if ($user->username() == $_SESSION['user']->username()) echo '<h1>Your profile</h1>';
                    else echo '<h1>'.$user->username().'\'s Profile</h1>'; 
                    echo '<img class="user" src="img/users/'.$user->id().'.jpg" onerror="this.src=\'img/users/placeholder.png\'">';
                    echo '<h2>Name: '.$user->username().'</h2>';
                    echo '<h2>Full Name: '.$user->fullname().'</h2>';
                    echo '<h2>E-mail: '.$user->email().'</h2>';
                    echo '<h2>Friends: <a href="friendsList.php?id='.$user->id().'">'.$user->numeroAmigos().'</a></h2>';
                    // Editar perfil
                    if ($user->username() == $_SESSION['user']->username()) echo '<h2><a href="userSettings.php">Edit Your Settings</a></h2>';
                ?>
            </div>
            <div class="profile-right">
            <?php
                if ($user->username() == $_SESSION['user']->username()) { // Tu perfil
                    echo '<div id="requests">';
                    if ($peticiones) { // Tienes peticiones nuevas pendientes
                        echo '<h1>New Friend Requests!</h1>';
                        while($row = $peticiones->fetch_assoc()) {
                            $sender = Usuario::buscaUsuarioId($row['idSender']);
                            echo '<h2>Friend request from: <a href="userProfile.php?id='.$sender->id().'">'.$sender->username().'</a></h2>';
                            // Botón de Aceptar | Rechazar
                            echo '<div class="inline-buttons">';
                                echo '<form action="include/friendRequest.php" method="POST">
                                    <input type="hidden" name="other" value="'.$sender->id().'">
                                    <input type="hidden" name="type" value="accept">
                                    <input type="submit" value="Accept"/> 
                                </form>';
                                echo '<form action="include/friendRequest.php" method="POST">
                                        <input type="hidden" name="other" value="'.$sender->id().'">
                                        <input type="hidden" name="type" value="decline">
                                        <input type="submit" value="Decline"/>
                                </form>';
                            echo '</div>';
                        }
                    } else {
                        echo '<h1>No new Friend Requests</h1>';
                    }
                    echo '</div>';

                    echo '<div id="friends">'; // Lista de amigos
                        echo '<h2><a href="gameList.php?id='.$user->id().'">My Game List</a></h2>';
                    echo '</div>';

                    echo '<div id="messages">'; // Lista de mensajes
                        echo '<h2><a href="messages.php">Messages</a></h2>';
                    echo '</div>';
                } else { // Perfil de otro usuario
                    echo '<h2><a href="gameList.php?id='.$user->id().'">'.$user->username().'\'s Game List</a></h2>';
                    // Comprueba que no sois amigos, o que no está aún a la espera de aceptar tu petición
                    if ($amigos) {
                        echo '<form action="include/friendRequest.php" method="POST">
                                <input type="hidden" name="other" value="'.$user->id().'">
                                <input type="hidden" name="type" value="delete">
                                <input type="submit" value="Delete Friend"/>
                            </form>';
                        // También os podéis mandar mensajes entre vosotros
                        echo '<form action="sendMessage.php" method="POST">
                                <input type="hidden" name="other" value="'.$user->id().'">
                                <input type="submit" value="Send a Message"/>
                            </form>';
                    } else if (!$pending) {
                        echo '<form action="include/friendRequest.php" method="POST">
                            <input type="hidden" name="other" value="'.$user->id().'">
                            <input type="hidden" name="type" value="add">
                            <input type="submit" value="Add Friend"/>
                        </form>';
                    } else { // Petición pendiente de respuesta
                        echo '<h2>Pending Friend Request</h2>';
                    }
                } 
            ?>
            </div>
        </div>
    </div>
    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>