<?php

    require_once __DIR__.'/Usuario.php';
    require_once __DIR__.'/config.php';

    $sender = $_SESSION['user']->id(); // Id del usuario que manda la petición (tú)
    $receiver = $_POST['other']; // Id del usuario que quires seguir
    $result = "";

    switch ($_POST['type']) { // 3 Tipos de peticiones: Add | Accept | Decline
        case "add": // Añade una petición de amistad - Perfiles ajenos al tuyo
            if (Usuario::creaPeticion($sender, $receiver)) {
                $result = "addOk";
            } else {
                echo 'Something went wrong...';
                exit();
            }
        break;
        case "accept": // Acepta una petición de amistad (añade al usuario a tu lista de amigos) - Propio Perfil
            if (Usuario::aceptaPeticion($receiver, $sender)) {
                $result = "acceptOk";
            } else {
                echo 'Something went wrong...';
                exit();
            }
        break;
        case "decline": // Declina la petición de amistad - Propio Perfil
            if (Usuario::declinaPeticion($receiver, $sender)) {
                $result = "declineOk";
                header('Location: ../userProfile.php?id='.$_SESSION['user']->id().'&result='.$result.'');
                exit();
            } else {
                echo 'Something went wrong...';
                exit();
            }
        break;
        case "delete": // Borra a un amigo de tu lista
            if (Usuario::borraAmigo($receiver, $sender)) {
                $result = "deleteOk";
            } else {
                echo 'Something went wrong...';
                exit();
            }
        break;
        default: 
            header('Location: ../error.php');
        break;
    }

    header('Location: ../userProfile.php?id='.$receiver.'&result='.$result.'');

?>