<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioEditUser extends Form {

     protected function generaCamposFormulario($datos) { // Devuelve el HTML necesario para presentar los campos del formulario.
        $print = '';
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "repeat") {
                $print = '<p>Unchanged values.</p>';
            }
        }
        $print = $print.'<div class="contenedor-add">
                    <div>
                        <div>
                            <table>
                            <tr>
                                <td>Name: </td>
                                <td><input class="form-control" id = "username" type="text" name="username" 
                                placeholder="username"/>
                                </td>
                            </tr>
                             <tr>
                                <td>Fullname: </td>
                                <td><input class="form-control" id = "FullName" type="text" name="FullName" 
                                placeholder="FullName"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Email: </td>
                                <td><input class="form-control" id = "email" type="text" name="email" 
                                placeholder="Email"/>
                                </td>
                            </tr>
                            <td>Profile Image: </td>
                            <td>
                                <input type="file" id="image" name="image" class="cover-image" accept="*" onchange="loadFile(event)">
                            </td>
                            <input type="hidden" name="id_user" value="'.$_SESSION['user']->id().'"/>
                            </table>
                        </div>
                    </div>
                    <button class="button-create">Update</button>
                </div>';
        return $print;
    }

    protected function procesaFormulario($datos) {
        $erroresFormulario = array();
        $userName = isset($datos['username']) ? $datos['username'] : null;
        $fullName = isset($datos['FullName']) ? $datos['FullName'] : null;
        $email = isset($datos['email']) ? $datos['email'] : null;
        $image = isset($_POST['image']) ? $_POST['image'] : null;

        if ($image != null) {
            $filename = $_SESSION['user']->id(); // El nombre de la imagen del usuario va a coincidir con su ID de perfil
            $i = 1;
           
            $name_file = $_FILES['image']['name']; // Nombre del archivo
            $tmp_name = $_FILES['image']['tmp_name'];  // Nombre y directorio temporal del archivo subido
            $extension = explode(".", $name_file)[1]; // Extensión del archivo
            $user = $_SESSION['user'];
            // Procesa la imagen
            if (!$user->uploadImage($tmp_name, $extension)) {
                echo 'No se ha podido subir la imagen al servidor.';
                exit();
            }        
        }

        if (empty($fullName) && empty($userName) && empty($email)) {
            $erroresFormulario[] = "You need to at least change one of the fields." ;
            $_GET['id'] = $_POST['id_user'];
        } else {
            $id = $_POST['id_user'];
            $user = Usuario::buscaUsuarioId($id);
            if (count($erroresFormulario) === 0) {
                $user->actualiza($datos);
                if (count($erroresFormulario) != 0) {
                    $erroresFormulario[] = "The information is the same!";
                } else {
                    header("Location: userProfile.php?id=".$datos['id_user']);
                }
            }
        }
        return $erroresFormulario;
    }

        
}

?>
