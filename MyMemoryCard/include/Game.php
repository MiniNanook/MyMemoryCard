<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Usuario.php';

class Game {

    // Variables de la clase Game

    private $id;
    private $title;
    private $year;
    private $company;
    private $platform;
    private $image;

    public function __construct($id, $title, $year, $company, $platform, $image) { // Constructor para la clase Game
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->company = ucfirst($company);
        $this->platform = $platform;
        $this->image = $image;
    }

    public static function delete($gameId) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM games WHERE id = '.$gameId.'';
        $result = $conn->query($sql);
        if ($result) {
            return true;
        }
        else return false; // Verdadero o falso si consige meter un juego en la base de datos
    }

    public function insertar($tags) { // Insertar juego en la base de datos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        // Convierte el año a formato DATE
        $time = strtotime($this->year);
        $date = date('Y-m-d', $time);
        $sql = 'INSERT INTO games(title, year, company, platform) VALUES (\''.$this->title.'\', \''.$date.'\', \''.$this->company.'\', \''.$this->platform.'\')';
        
        $result = $conn->query($sql);
        if ($result) {
            // Guarda el ID
            $this->id = $conn->insert_id;
            // Guarda los géneros del juego en la tabla de géneros
            return $this->addGenres($tags);
        }
        else return false; // Verdadero o falso si consige meter un juego en la base de datos
    }

    public function addGenres($genres) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        // Parte los géneros en subcadenas
        $genre = strtok($genres, ", ");
        $sql = 'INSERT INTO gamegenres VALUES ('.$this->id.', \''.$genre.'\')'; // Inicio de consulta SQL
        $genre = strtok(", ");
        while ($genre !== false) {
            $sql = $sql.', ('.$this->id.', \''.$genre.'\')';
            $genre = strtok(", ");
        }
        echo ''.$sql;
        $result = $conn->query($sql);
        if ($result) {
            return true;
        }
        else return false; // Verdadero o falso si consige meter un juego en la base de datos
    }

    public static function find($id) { // Búsqueda de un juego dado su ID
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM games WHERE id = '.$id.'';
        $result = $conn->query($sql);
        if ($result) {
            if ($result->num_rows == 1) {
                $game = $result->fetch_assoc();
                $game = new Game($game['id'], $game['title'], $game['year'], $game['company'], $game['platform'], NULL);
                return $game;
            }
        } else {
            return false;
        }
    }

    public function getReviews() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM gamereviews WHERE idGame = '.$this->id().' ORDER BY time DESC'; // Coge todas las reviews que se hayan hecho al juego
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result; // Devuelve todas las reviews
        } else {
            return false; // Algo ha ido mal
        }
    }

    public function average() { // Calcula la nota media de todos los usuarios que hayan jugado a este juego
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM mygames WHERE gameId = '.$this->id.'';
        $result = $conn->query($sql);
        if ($result) {
            $sum = 0; // Suma de todas las notas
            if ($result->num_rows > 0) {
                while ($game = $result->fetch_assoc()) {
                    if ($game['rating'] == "-") { // Para no bajar demasiado la media ponemos a 5 cualquier nota que no haya sido especificada
                        $sum += 5;
                    } else $sum += $game['rating'];
                }
                $sum = round($sum / $result->num_rows, 2); // Nota media = Suma de las notas / Número de usuarios que han votado
                $this->updateAverage($sum); // Actualiza la nota media del juego
                return 'Average Score: '.$sum.'/10 ('.$result->num_rows.' Players)'; // Nota media
            } else {
                $this->updateAverage($sum);
                return 'Average Score: N/A ('.$result->num_rows.' Players)'; // Juego no añadido a ninguna lista
            }
        } else {
            $this->updateAverage($sum);
            return "N/A"; // Juego no añadido a ninguna lista
        }
    }

    private function updateAverage($sum) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sum = number_format($sum, 2, '.', '.');
        $sql = 'UPDATE games SET average = '.$sum.' WHERE id = '.$this->id.'';
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function addReview($id, $score, $title, $review) { // Añade una review de un juego a la base de datos
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $user = $_SESSION['user']->id();
        $time = time();
        $fullTime = date('Y-m-d H:i:s', $time);
        $sql = 'INSERT INTO gamereviews VALUES ('.$user.', '.$id.', '.$score.', \''.$title.'\', \''.$review.'\', \''.$fullTime.'\')';
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function processImage($tmp_name, $extension) { // Subida de imágenes de carátula del juego
        $result = false;
        // Es posible que la plataforma del juego tenga varias palabras: PlayStation 3, 4... / XBox 360, One...
        // Por ello reemplazo los espacios por rallas
        $this->platform = str_replace(" ", "/", $this->platform);
        $path = 'img/games/'.$this->company.'/'.$this->platform.'/'; // Nombre y directorio nuevo del archivo
        if (!file_exists('img/games/'.$this->company.'/'.$this->platform.'/')) {
            mkdir('img/games/'.$this->company.'/'.$this->platform.'/', 0777, true);
        }
        if (move_uploaded_file($tmp_name, $path.$this->id.'.'.$extension)) {
            echo 'Good!';
            $result = true;
        } else {
            echo 'Something went wrong...';
            echo ''.$path;
            echo ''.$path.$this->id.'.'.$extension;
            exit();
        }
        return $result;
    }

    // Funciones para la Home

    public static function topTen() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM games ORDER BY average DESC LIMIT 10'; // Cógeme los 10 primeros juegos ordenados por la nota media
        $result = $conn->query($sql);
        if ($result) {
            return $result; // Devuelve el top 10
        } else {
            return false; // Algo ha ido mal
        }
    }

    public static function recommend($genres, $myList) { // Esta función te devuelve una lista de juegos a los que no hayas jugado aún que te podrían gustar
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $size = sizeof($genres);
        $i = 0;
        $sql = 'SELECT DISTINCT id FROM games JOIN gamegenres ON id = gameId WHERE (';
        foreach($genres as &$genre) {
            $sql = $sql.'genre LIKE \''.$genre.'\'';
            $i++;
            if ($i < $size) $sql = $sql.' OR ';
        }
        // Coge solo aquellos que no estén en mi lista
        $sql = $sql.') AND (';
        $counter = 0;
        while ($row = $myList->fetch_assoc()) { // Quita los que estén ya en mi lista
            $counter++;
            $sql = $sql.' id != '.$row['gameId'].'';
            if ($counter < $myList->num_rows) {
                $sql = $sql.' AND';
            }
        }
        $sql = $sql.')';
        $sql = $sql.' LIMIT 10'; // Cógeme los 10 primeros juegos recomendados por géneros
        $result = $conn->query($sql);
        if ($result) {
            return $result; // Devuelve los juegos recomendados
        } else {
            return false; // Algo ha ido mal
        }
    }

    public function searchString() { // Método toString para la búsqueda de juegos
        $title = $this->title;
        $year = $this->year;
        $company = $this->company;
        $platform = $this->platform;
        $id = $this->id;
        return '<h1><a href="gamePage.php?id='.$id.'">'.$title.'</a></h1>
                <h2>'.$year.'</h2>
                <h3>'.$company.' | '.$platform.'</h3>
                <h3>'.$this->average().'</h3>';
    }

    public function toString() { // Método toString genérico
        $title = $this->title;
        $year = $this->year;
        $company = $this->company;
        $id = $this->id;
        return '<h1><a href="gamePage.php?id='.$id.'">'.$title.'</a></h1>
                <h2>'.$year.'</h2>
                <h3>'.$company.'</h3>
                <h3>'.$this->average().'</h3>';
    }

    public function topTenString() {
        $platform = str_replace(" ", "/", $this->platform); // En caso de que tenga espacios
        return '<h1><a href="gamePage.php?id='.$this->id.'">'.$this->title.'</a></h1>
        <a href="gamePage.php?id='.$this->id.'"><img class="home-game" src="img/games/'.$this->company.'/'.$platform.'/'.$this->id.'.jpg" onerror="this.src=\'img/games/placeholder.png\'"></a>
        <h2>'.$this->company().' | '.$this->platform().'</h2>
        <h3>Release: '.$this->year.'</h3>
        <h2>'.$this->average().'</h2>
        ';
    }

    // Getters de variables privadas de la clase Game

    public function id() {
        return $this->id;
    }

    public function title() {
        return $this->title;
    }

    public function year() {
        return $this->year;
    }

    public function company() {
        return $this->company;
    }

    public function platform() {
        return $this->platform;
    }

    public function image() {
        return $this->id;
    }

    public function genres() {
        return $this->getGenres();
    }

    public function genresString() {
        $genres = $this->getGenres();
        $string = "";
        while ($genre = $genres->fetch_assoc()) {
            $string = $string.', '.$genre['genre'];
        }
        return ltrim($string, ', ');
    }

    public function getGenres() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM gamegenres WHERE gameId = '.$this->id.''; // Cógeme los 10 primeros juegos ordenados por la nota media
        $result = $conn->query($sql);
        if ($result) {
            return $result; // Devuelve los géneros del juego
        } else {
            return false; // Algo ha ido mal
        }
    }

    // Funciones Exclusivas del Administrador

    public static function dumpGames($user) { // Devuelve todos los juegos que estén guardados en la base de datos
        if (strcmp($user->rol(), 'admin') == 0 ? true : false) {
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $sql = 'SELECT * FROM games';
            $result = $conn->query($sql);
            if ($result->num_rows == 0) return false;
            else return $result;
        } else { // No deberías de estar aquí metido
            header('Location: ../error.php');
        }
    }

    public static function dumpGamesParsed($user, $text) {
        if (strcmp($user->rol(), 'admin') == 0 ? true : false) {
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $sql = 'SELECT * FROM games WHERE title LIKE \''.$text.'%\''; // La razón por la que no me devuelvo a mi mismo (admin) es para evitar que el administrador se borre por error
            $result = $conn->query($sql);
            if ($result->num_rows == 0) return false;
            else return $result;
        } else { // No deberías de estar aquí metido
            header('Location: ../error.php');
        }
    }

}
 