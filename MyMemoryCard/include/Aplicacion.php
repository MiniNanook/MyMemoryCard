<?php

class Aplicacion { // Clase que mantiene el estado global de la aplicación.

	/*Variables*/

	private static $instancia;
	private $bdDatosConexion; // @var array Almacena los datos de configuración de la BD
	private $inicializada = false; // @var boolean Almacena si la Aplicacion ya ha sido inicializada.
	private $conn; // @var \mysqli Conexión de BD.

	/*Funciones*/

	public static function getSingleton() { // @return Applicacion Obtiene la única instancia de la <code>Aplicacion</code>
		if (  !self::$instancia instanceof self) {
			self::$instancia = new self;
		}
		return self::$instancia;
	}

	private function __construct() {} // Constructor vacío -> Evita que se pueda instanciar la clase directamente.

	private function __clone() { // Evita que se pueda utilizar el operador clone.
	    parent::__clone();
	}
	
	private function __wakeup() { // Evita que se pueda utilizar unserialize().
	    return parent::__wakeup();
	}
	
	public function init($bdDatosConexion) { // @param array $bdDatosConexion datos de configuración de la BD -> Inicializa la aplicación.
        if ( ! $this->inicializada ) {
    	    $this->bdDatosConexion = $bdDatosConexion;
    		session_start();
    		$this->inicializada = true;
        }
	}
	
	public function shutdown() { // Cerrar la aplicacion
	    $this->compruebaInstanciaInicializada();
	    if ($this->conn !== null) {
	        $this->conn->close();
	    }
	}
	
	private function compruebaInstanciaInicializada() { // Comprueba si la aplicación está inicializada. Si no lo está muestra un mensaje y termina la ejecución.
	    if (! $this->inicializada ) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	public function conexionBd() { // @return \mysqli Conexión a MySQL. -> Devuelve una conexión a la BD. Se encarga de que exista como mucho una conexión a la BD por petición.
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['user'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bd = $this->bdDatosConexion['bd'];
			
			$this->conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
			if ( $this->conn->connect_errno ) {
				echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}
}

?>