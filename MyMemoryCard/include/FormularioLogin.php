<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioLogin extends Form {

    protected function generaCamposFormulario($datosinicio) {
        return '<fieldset>
                <legend>Log In</legend>
                <div class="grupo-control">
                    <label>Nombre de usuario:</label> 
                    <input class="form-control" type="text" name="username" placeholder="Username"/>
                </div>
                <div class="grupo-control">
                    <label>Password:</label> 
                    <input class="form-control" type="password" name="password" placeholder="*****"/>
                </div>
                <div class="grupo-control">
                    <button type="submit" name="login">Login</button>
                </div>
                </fieldset>';
    }

    protected function procesaFormulario($datosproceso) {
        $erroresFormulario = array();
    
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        
        if (empty($username)) {
            $erroresFormulario[] = "Username cannot be empty.";
        }
        
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "Password cannot be empty.";
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::buscaUsuario($username);
        
            if (!$usuario) {
                $erroresFormulario[] = "Incorrect username or password.";
            } else {
                if ($usuario->compruebaPassword($password)) {
                    $_SESSION['user'] = $usuario;
                    $_SESSION['login'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $usuario->email();
                    $_SESSION['isAdmin'] = strcmp($usuario->rol(), 'admin') == 0 ? true : false;
                    header('Location: index.php');
                    exit();
                } else {
                    $erroresFormulario[] = "Incorrect username or password";
                }
            }
        }
        return $erroresFormulario;
    }
        
}

?>
