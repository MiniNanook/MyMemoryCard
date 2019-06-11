<?php
	require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/FormularioLogin.php';
    require_once __DIR__.'/include/FormularioRegistro.php';
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        header("Location: index.php"); // If the user is already logged in, take him to the Home page
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>MyMemoryCard</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/perfil.css">
</head>
<body>
    <div class="header">
        <img class="centered" src="img/logo-header.png" alt="RateMyPet">
    </div>

    <div class="split left">
        <div class="centered">
            <?php
				$opciones = array(); // Ninguna por defecto
				$formulario = new FormularioLogin("Login", $opciones); // Créame una instancia hija de Form de tipo FormularioLogin
				$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Login
			?>
        </div>
    </div>

    <div class="split right">
        <div class="centered">
            <?php
				$opciones = array(); // Ninguna por defecto
				$formulario = new FormularioRegistro("Register", $opciones); // Créame una instancia hija de Form de tipo FormularioLogin
				$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Login
			?>
        </div>
    </div>
</body>
</html>