<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Game.php';

class FormularioReview extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        $gameId = $_POST['gameId'];
        return '<div class="contenedor-add">
                    <div>
                        <div class="contenedor-title">
                        Score: <select class="form-control" id="score" type="text" name="score">
                        <option value="-">-</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
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
                            <td>Review: </td>
                            <td>
                                <textarea rows="4" cols="50" name="review" required></textarea>
                            </td>
                        </tr>
                        <input type="hidden" value="'.$gameId.'" name="game">
                    </table>
                </div>
                <div class="button-wrapper">
                   <button type="submit" class="button-create-game" id="game">Send</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.
        $score = isset($datos['score']) ? $datos['score'] : null;
        $title = isset($datos['title']) ? $datos['title'] : null;
        $review = isset($datos['review']) ? $datos['review'] : null;
        $game = Game::find($datos['game']);

        if ($game->addReview($game->id(), $score, $title, $review)) { // Review correctamente añadida
            header('Location: gamePage.php?id='.$game->id().'&reviewPosted');
            exit();
        } else { // Error al intentar enviar el mensaje
            header('Location: gamePage.php?id='.$game->id().'&reviewError');
            exit();
        }
    }

}

?>