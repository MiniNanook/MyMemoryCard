<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Game.php';

class FormularioGame extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        return '<div>
                    <div class="game-title">
                        <h2>Add a Game</h2>
                    </div>
                    <img class="cover-img" src="img/games/placeholder.png" class="preview" id="output"/>
                    <p class="centered">Image Preview</p>
                    <table>
                        <tr>
                            <td>Title: </td>
                            <td>
                                <input class="form-control" id = "title" type="text" name="title" placeholder="Title" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Release Year: </td>
                            <td>
                                <input class="form-control" id = "year" type="date" name="year" placeholder="DD-MM-YYYY" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Company | Platform: </td>
                            <td>
                                <select name="company" id="company" class="form-control" onChange="getCompany()">
                                <option value="Nintendo 64">Nintendo 64</option>
                                <option value="Nintendo GameCube">Nintendo GameCube</option>
                                <option value="Nintendo Wii">Nintendo Wii</option>
                                <option value="Nintendo Wii U">Nintendo Wii U</option>
                                <option value="Nintendo Switch">Nintendo Switch</option>
                
                                <option value="Sony PlayStation 1">Sony PlayStation 1</option>
                                <option value="Sony PlayStation 2">Sony PlayStation 2</option>
                                <option value="Sony PlayStation 3">Sony PlayStation 3</option>
                                <option value="Sony PlayStation 4">Sony PlayStation 4</option>
                
                                <option value="Microsoft XBox">Microsoft XBox</option>
                                <option value="Microsoft XBox 360">Microsoft XBox 360</option>
                                <option value="Microsoft XBox One">Microsoft XBox One</option>
                
                                <option value="Other">Other</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Tags | Genres: </td>
                            <td>
                                <input class="form-control" id = "tags" type="text" name="tags" placeholder="RPG, Sports, Platforms, Puzzle" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Cover Image: </td>
                            <td>
                                <input type="file" id="image" name="image" class="cover-image" accept="*" onchange="loadFile(event)">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="button-wrapper">
                   <button type="submit" class="button-create-game" id="game">Create!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.

        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $year = isset($_POST['year']) ? $_POST['year'] : null;
        $company = isset($_POST['company']) ? $_POST['company'] : null;
        $image = isset($_POST['image']) ? $_POST['image'] : null;
        $tags = isset($_POST['tags']) ? $_POST['tags'] : null;

        $all_ = explode(" ", $company);  
        $company = $all_[0];
        $index = 2;
        $platform = $all_[1];

        while ($index < sizeof($all_)) {
            $platform = $platform.' '.$all_[$index];
            $index++;
        }

        if (empty($title) or empty($year) or empty($company))	{
            header('Location: addGame.php?error=missing');
            exit();
        } else{
            
            $game = new Game(NULL, $title, $year, $company, $platform, $image, $tags); // Créame un nuevo objeto de tipo juego
            $insert = $game->insertar($tags);
            if ($insert) { // Hemos podido insertar el juego en la base de datos
                // Guarda la imagen en los archivos
                if (isset($_FILES['image'])) {
                    $fullTitle = explode(" ", $title);
                    $filename = $fullTitle[0];
                    $i = 1;
                    while ($i < sizeof($fullTitle)) {
                        $filename = $filename.'_'.$fullTitle[$i];
                        $i++;
                    }
                   
                    $name_file = $_FILES['image']['name']; // Nombre del archivo
                    $tmp_name = $_FILES['image']['tmp_name'];  // Nombre y directorio temporal del archivo subido
                    $extension = explode(".", $name_file)[1]; // Extensión del archivo
                    
                    // Procesa la imagen
                    if (!$game->processImage($tmp_name, $extension)) {
                        echo 'No se ha podido subir la imagen al servidor.';
                    }        
                } else {
                    echo 'Please upload an image!';
                    exit();
                }

                header('Location: addGame.php?success');
                exit();
            } else {
                header('Location: addGame.php?error=insert');
                exit();
            }
        }
    }

}

?>