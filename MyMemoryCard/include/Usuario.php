<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Game.php';

class Usuario {

    // Variables

    private $id; // Auto-set
    private $username; // User specified
    private $password; // User specified
    private $fullname; // User specified
    private $email; // User specified
    private $rol; // Admin specified

    private function __construct($username, $fullname, $password, $email, $rol) {
        $this->username= $username;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->email = $email;
        $this->rol = $rol;
    }

    public static function delete($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM users WHERE id = '.$id.'';
        $result = $conn->query($sql);
        if ($result) {
            return true;
        }
        else return false; // Verdadero o falso si consige meter un juego en la base de datos
    }

    public static function login($username, $password) {
        $user = self::buscaUsuario($username);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public function addGame($game, $score, $status, $isFavourite) { // Añade el juego a la lista de mis juegos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        if ($isFavourite) $isFavourite = 1;
        else $isFavourite = 0;
        $sql = 'INSERT INTO mygames VALUES ('.$this->id().', '.$game->id().', '.$score.', \''.$status.'\', '.$isFavourite.')';
        echo ''.$sql;
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteGame($game) { // Borra el juego de la lista de mis juegos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM mygames WHERE userId = '.$this->id.' AND gameId = '.$game->id().'';
        echo ''.$sql;
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function changeGame($game, $score, $status, $isFavourite) { // Actualiza el juego de la lista de mis juegos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        if ($isFavourite) $isFavourite = 1;
        else $isFavourite = 0;
        $sql = 'UPDATE mygames SET rating = '.$score.',  status = \''.$status.'\', isFavourite = '.$isFavourite.' WHERE userId = '.$this->id.' AND gameId = '.$game->id().'';
        echo ''.$sql;
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function findGame($game) { // Devuelve si tienes un juego en tu lista
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM mygames WHERE userId = '.$this->id.' AND gameId = '.$game->id().'';
        if ($conn->query($sql)->num_rows == 1) {
            return $conn->query($sql)->fetch_assoc();
        } else {
            return false;
        }
    }

    public function findReview($game) { // Devuelve si tienes una reseña hecha de este juego
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM gamereviews WHERE idUser = '.$this->id.' AND idGame = '.$game->id().'';
        if ($conn->query($sql)->num_rows == 1) {
            return $conn->query($sql)->fetch_assoc();
        } else {
            return false;
        }
    }

    public function getGameList($tags) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = "";
        if ($tags == "none") $sql = 'SELECT * FROM mygames WHERE userId = '.$this->id;
        else {
            $order = "";
            switch ($tags) {
                case "score": $order = "rating";
                break;
                case "favourites": $order = "isFavourite";
                break;
                case "title": $order = "title";
                break;
                case "status": $order = "status";
                break;
                default: $order = "title";
                break;
            }
            // Si quiero orden de favoritos, prefiero que aparezcan arriba primero los favoritos, y luego los demás
            if ($tags == "title") $sql = 'SELECT * FROM mygames JOIN games WHERE gameId = id AND userId = '.$this->id.' ORDER BY '.$order.' ASC';
            else $sql = 'SELECT * FROM mygames JOIN games WHERE gameId = id AND userId = '.$this->id.' ORDER BY '.$order.' DESC';
        }
        if ($conn->query($sql)->num_rows > 0) {
            return $conn->query($sql);
        } else {
            return false;
        }
    }

    public function getFavouriteGameList() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM mygames WHERE userId = '.$this->id.' AND isFavourite = 1 LIMIT 10';
        if ($conn->query($sql)->num_rows > 0) {
            return $conn->query($sql);
        } else {
            return false;
        }
    }

    public static function buscaUsuario($username) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM users U WHERE U.username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc(); // Add following parameters
                $user = new Usuario($fila['username'], $fila['fullname'], $fila['password'], $fila['email'], $fila['rol']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function buscaUsuarioId($id) { // Returns user given an ID
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM users U WHERE U.id = '%s'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc(); // Add following parameters
                $user = new Usuario($fila['username'], $fila['fullname'], $fila['password'], $fila['email'], $fila['rol']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public function recommend($favs) { // Esta función te devuelve una lista de usuarios que podrían ser buenos amigos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $recommended = array(); // Array de IDs de usuarios que podríán ser buenos amigos
        
        // Itera por todos los usuarios, coge su lista de favoritos, y si no somos amigos, y alguno de nuestros favoritos coincide, recomiéndamelo
        $sql = 'SELECT * FROM users WHERE id != '.$this->id().''; // Dame todos los usuarios que no sean yo
        $users = $conn->query($sql);
        while ($row = $users->fetch_assoc()) { // Itera todos los usuarios
            $user = Usuario::buscaUsuarioId($row['id']); // Usuario
            $otherFavs = $user->getFavouriteGameList(); // Favoritos de ese usuario
            if ($this->compareFavs($favs, $otherFavs)) { // Función que me compara favoritos - Si tenemos al menos un juego favorito en común, me lo añade
                $recommended[] = $user->id(); // Añádeme el ID de este usuario a la lista de usuarios que debería seguir
            } 
        }
        return $recommended;
    }

    private function compareFavs($mine, $other) {
        // Desafortunadamente, aquí debemos de ir uno a uno mirando a ver si coinciden en ID, así que es un algoritmo necesariamente cuadrático
        if (!$other) return false; // Si el otro no tiene favoritos en la lista, pasa a la siguiente persona
        while ($x = $mine->fetch_assoc()) { // Itera mis favoritos
            while ($y = $other->fetch_assoc()) { // Itera sus favoritos
                if ($x['gameId'] == $y['gameId']) { // Coinciden favoritos
                    return !$this->esAmigo($y['userId']); // Si no somos amigos, podríamos serlo
                }
            }
        } return false; // No ha habido ninguna coincidencia
    }
    
    public static function crea($username, $fullname, $password, $email, $rol) {
        $user = self::buscaUsuario($username);
        if ($user) {
            return false;
        }
        $user = new Usuario($username, $fullname, self::hashPassword($password), $email, $rol, 0, 0);
        return self::guarda($user);
    }
    
    private static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function guarda($usuario) {
        if ($usuario->id !== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }
    
    private static function inserta($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO users(username, fullname, password, email, rol) VALUES('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->fullname)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->rol));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
    
    public function actualiza($datos) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        // Check that what you're changing is different from what you have

        $name = isset($datos['username']) ? $datos['username'] : null;
        $fullName = isset($datos['FullName']) ? $datos['FullName'] : null;
        $email = isset($datos['email']) ? $datos['email'] : null;

        if ($name != "" && $name != $this->username) { // Change username
            $this->username = $name;
        }

        if ($fullName != "" && $fullName != $this->fullname) {
            $this->fullname = $fullName;
        }

        if ($email != "" && $name != $this->email) {
            $this->email = $email;
        }

        $sql = 'UPDATE users U SET username = \''.$this->username.'\', fullname = \''.$this->fullname.'\', email = \''.$this->email.'\' WHERE U.id = '.$this->id.'';
        
        if ($conn->query($sql) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $this->username;
                header("Location: updateUser.php?id=".$datos['id_user'].'&error=repeat');
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
       
    }

    // Peticiones de Amistad

    public static function creaPeticion($sender, $receiver) { // Crea una entrada en la base de datos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'INSERT INTO friendrequests VALUES ('.$sender.', '.$receiver.')';
        $result = $conn->query($sql);
        return $result;
    }

    public static function aceptaPeticion($sender, $receiver) { // Acepta una petición de amistad
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'INSERT INTO friends VALUES ('.$sender.', '.$receiver.')'; // Ahora sois amigos
        $result = $conn->query($sql);
        if ($result) { // Todo correcto
            $sql = 'DELETE FROM friendrequests WHERE idSender = '.$sender.' AND idReceiver = '.$receiver.''; // Elimina la petición de amistad
            $result = $conn->query($sql);
        }
        return $result;
    }

    public static function declinaPeticion($sender, $receiver) { // Rechaza una petición de amistad
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM friendrequests WHERE idSender = '.$sender.' AND idReceiver = '.$receiver.''; // Borra la petición
        $result = $conn->query($sql);
        return $result;
    }

    public static function sendMessage($idSender, $idReceiver, $title, $message) { // Envía un mensaje
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        // Coge la hora y el día actual
        $time = time();
        $fullTime = date('Y-m-d H:i:s', $time);
        $sql = 'INSERT INTO messages VALUES (NULL, '.$idSender.', '.$idReceiver.', \''.$title.'\', \''.$message.'\', \''.$fullTime.'\')'; // Envía el mensaje
        $result = $conn->query($sql);
        return $result;
    }

    public static function borraAmigo($sender, $receiver) { // Rechaza una petición de amistad
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM friends WHERE idFriendA = '.$sender.' AND idFriendB = '.$receiver.' OR idFriendA = '.$receiver.' AND idFriendB = '.$sender.' '; // ¿Somos amigos?
        $result = $conn->query($sql);
        return $result;
    }

    public function cargaPeticiones() { // Devuelve una lista con todas las peticiones pendientes de amistad
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM friendrequests WHERE idReceiver = '.$this->id.''; // Todas las peticiones que me han enviado a mí
        $result = $conn->query($sql);
        if ($result->num_rows == 0) return false;
        else return $result;
    }

    public function cargaMensajes() { // Devuelve una lista con todas los mensajes que tienes, ordenados por fecha (más actual primero)
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM messages WHERE idReceiver = '.$this->id.' ORDER BY time DESC'; // Todos los mensajes ordenados por fecha/hora de envío
        $result = $conn->query($sql);
        if ($result->num_rows == 0) return false;
        else return $result;
    }


    public function compruebaPeticion($id) { // Devuelve una lista con todas las peticiones pendientes de amistad
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM friendrequests WHERE idSender = '.$id.' AND idReceiver = '.$this->id.' OR idSender = '.$this->id.' AND idReceiver = '.$id.''; // Comprueba si existe una petición hacia, o desde, este usuario
        $result = $conn->query($sql);
        if ($result->num_rows == 0) return false;
        else return $result;
    }

    public function numeroAmigos() { // Devuelve el valor numérico de los amigos que tienes
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM friends WHERE idFriendA = '.$this->id.' OR idFriendB = '.$this->id.''; // Número de amigos que tengo
        $result = $conn->query($sql);
        return $result->num_rows;
    }

    public function amigos() { // Devuelve una lista con todos tus amigos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM friends WHERE idFriendA = '.$this->id.' OR idFriendB = '.$this->id.''; // Amigos
        $result = $conn->query($sql);
        if ($result->num_rows == 0) return false;
        else return $result;
    }

    public function esAmigo($id) { // Comprueba si este usuario y el enviado son amigos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM friends WHERE idFriendA = '.$this->id.' AND idFriendB = '.$id.' OR idFriendA = '.$id.' AND idFriendB = '.$this->id.' '; // ¿Somos amigos?
        $result = $conn->query($sql);
        if ($result->num_rows != 1) return false;
        else return true;
    }

    public function compruebaPassword($password) {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword) {
        $this->password = self::hashPassword($nuevoPassword);
    }

    public static function toString($usuario) { // Formato String clase Usuario
        $nick = $usuario['username'];
        $name = $usuario['fullname'];
        $email = $usuario['email'];
        $id = $usuario['id'];
        return '<h1><a href="userProfile.php?id='.$id.'">'.$nick.'</a></h1>
                <h2>'.$name.'</h2>
                <h3>'.$email.'</h3>
                </br>';
    }

    public function formatoUsuario() { // Formato String objeto de tipo Usuario
        return '<h1><a href="userProfile.php?id='.$this->id.'">'.$this->username.'</a></h1>
                <h2>'.$this->username.'</h2>
                <h3>'.$this->email.'</h3>
                </br>';
    }

    // Getters de la clase Usuario

    public function fullname() {
        return $this->fullname;
    }

    public function id() {
        return $this->id;
    }

    public function rol() {
        return $this->rol;
    }

    public function username() {
        return $this->username;
    }

    public function email() {
        return $this->email;
    }

    public function profileImage() {
        return '<a href="userProfile.php?id='.$this->id.'"><img class="home-user" src="img/users/'.$this->id.'.jpg" onerror="this.src=\'img/users/placeholder.png\'"></a>';
    }

    public function uploadImage($tmp_name, $extension) {
        $result = false;
        $path = 'img/users/'; // Nombre y directorio nuevo del archivo
        if (move_uploaded_file($tmp_name, $path.$this->id.'.'.$extension)) {
            echo 'Good!';
            $result = true;
        } else {
            echo 'Something went wrong...';
            exit();
        }
        return $result;
    }

    // Funciones Exclusivas del Administrador

    public static function dumpUsers($user) {
        if (strcmp($user->rol(), 'admin') == 0 ? true : false) {
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $sql = 'SELECT * FROM users WHERE id != '.$user->id().''; // La razón por la que no me devuelvo a mi mismo (admin) es para evitar que el administrador se borre por error
            $result = $conn->query($sql);
            if ($result->num_rows == 0) return false;
            else return $result;
        } else { // No deberías de estar aquí metido
            header('Location: ../error.php');
        }
    }

    public static function dumpUsersParsed($user, $text) {
        if (strcmp($user->rol(), 'admin') == 0 ? true : false) {
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $sql = 'SELECT * FROM users WHERE username LIKE \''.$text.'%\' AND id != '.$user->id().''; // La razón por la que no me devuelvo a mi mismo (admin) es para evitar que el administrador se borre por error
            $result = $conn->query($sql);
            if ($result->num_rows == 0) return false;
            else return $result;
        } else { // No deberías de estar aquí metido
            header('Location: ../error.php');
        }
    }

}
