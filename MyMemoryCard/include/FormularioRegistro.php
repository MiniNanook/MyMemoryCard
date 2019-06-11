<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioRegistro extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        return '<fieldset>
                <legend>Register</legend>
                <div class="grupo-control">
                    <label>Username:</label>
                        <input class="form-control" type="text" name="username" placeholder="Name" />
                </div>
                <div class="grupo-control">
                    <label>Full Name:</label> <input class="form-control" type="text" name="fullname" placeholder="Name" />
                </div>
                <div class="grupo-control">
                    <label>E-Mail:</label> <input class="form-control" type="text" name="email" placeholder="youremail@mail.com" />
                </div>
                <div class="grupo-control">
                    <label>Password:</label> <input class="form-control" type="password" name="password" placeholder="*****" />
                </div>
                <div class="grupo-control">
                    <label>Re-enter Password:</label>
                        <input class="form-control" type="password" name="password2" placeholder="*****" />
                        <br />
                </div>
                <div>
                    <input type="checkbox" name="terms"> I have read the <a href="terms.php">Terms & Conditions<a/><br>
                </div>

                <div class="grupo-control">
                    <button type="submit" name="registro">Create an Account</button>
                </div>
                </fieldset>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario.
        $erroresFormulario = array();

        $username = isset($_POST['username']) ? $_POST['username'] : null;
        
        if ( empty($username) || mb_strlen($username) < 5 ) {
            $erroresFormulario[] = "Username cannot be shorter than 5 characters.";
        }
        
        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : null;
        if (empty($fullname)) {
            $erroresFormulario[] = "Your full name cannot be empty.";
        }
        
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        if (empty($email)) {
            $erroresFormulario[] = "Email cannot be empty.";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erroresFormulario[] = "Invalid email format."; 
            }
        }
        
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "Password must be at least 5 characters long.";
        }

        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Passwords do not match.";
        }

        $terms = isset($_POST['terms']) ? $_POST['terms'] : null;
        if ( empty($terms) || $terms == false ) {
            $erroresFormulario[] = "You must accept our terms and conditions.";
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::crea($username, $fullname, $password, $email, 'user');
            
            if (! $usuario ) {
                $erroresFormulario[] = "Username already in use.";
            } else {
                $_SESSION['user'] = $usuario;
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $usuario->email();
                $_SESSION['isAdmin'] = strcmp($usuario->rol(), 'admin') == 0 ? true : false;
                header('Location: index.php');
                exit();
            }
        } 
        return $erroresFormulario; // Array con los errores que ha habido durante el procesamiento del formulario.
    }

}

?>