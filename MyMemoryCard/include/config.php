<?php

require_once __DIR__.'/Aplicacion.php';
require_once __DIR__.'/Usuario.php';

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'mygamelist');
define('BD_USER', 'root');
define('BD_PASS', '');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

// Inicializa la aplicación
$app = Aplicacion::getSingleton();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));
$conn = $app->conexionBd();

// Retrieve user ID if possible

if (isset($_SESSION['username'])) {
    $sql = sprintf("SELECT id FROM users  WHERE username = '%s'", $_SESSION['username']); // Retrieve user id
    $result = $conn->query($sql);
    $owner_id = -1;

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $owner_id = $row['id'];
            $_SESSION['owner_id'] = $owner_id;
        }
    } else {
        unset($_SESSION['owner_id']);
    }
}

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
register_shutdown_function(array($app, 'shutdown'));

?>