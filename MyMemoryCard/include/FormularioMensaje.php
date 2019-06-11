<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Game.php';

class FormularioMensaje extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        $id = $_POST['other'];
        $other = Usuario::buscaUsuarioId($id);
        if (!$other) {
            header('Location: error.php');
            exit();
        }
        return '<div class="contenedor-add">
                    <div>
                        <div class="contenedor-title">
                            <h2>Send Message to: '.$other->username().'</h2>
                        </div>
                    </div>
                    <table>
                        <tr>
                            <td>Title: </td>
                            <td>
                                <input class="form-control" id = "title" type="text" name="title" placeholder="Title" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Message: </td>
                            <td>
                                <textarea rows="4" cols="50" name="message" placeholder="Dear '.$other->username().'..." required></textarea>
                            </td>
                        </tr>
                        <input type="hidden" id="other" name="other" value="'.$id.'">
                    </table>
                </div>
                <div class="button-wrapper">
                   <button type="submit" class="button-create-game" id="game">Send</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.

        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $message = isset($_POST['message']) ? $_POST['message'] : null;

        // Ya compruebo con el "required" que ambos campos estén llenos antes de poderse enviar el mensaje

        $idSender = $_SESSION['user']->id();
        $idReceiver = $_POST['other'];

        if (Usuario::sendMessage($idSender, $idReceiver, $title, $message)) { // Mensaje correctamente añadido
            header('Location: userProfile.php?id='.$idReceiver.'&messageSent');
            exit();
        } else { // Error al intentar enviar el mensaje
            header('Location: userProfile.php?id='.$idReceiver.'&messageError');
            exit();
        } 
        
    }

}

?>