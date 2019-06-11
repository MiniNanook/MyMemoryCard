<?php
	require_once __DIR__.'/config.php';

	//Doble seguridad: unset + destroy
	unset($_SESSION["login"]);
	unset($_SESSION["esAdmin"]);
	unset($_SESSION["nombre"]);

    session_destroy();
    header("Location: ../signup.php");
?>