<?php
require_once __DIR__ . '/include/Aplicacion.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/FormularioEditUser.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>User Settings</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/content.css">
	<link rel="stylesheet" href="css/settings.css">
</head>

<body>
	<?php
	require("include/comun/header.php");
	?>
	<div class="content">
		<h2 class="title">Edit profile</h2>
		<?php
			echo '<img id="output" class="profile" src="img/users/'.$_SESSION['user']->id().'.jpg" onerror="this.src=\'img/users/placeholder.png\'">';
		?>
        <p class="centered">Image Preview</p>
		<?php
		$opciones = array(); // Ninguna por defecto
		$formulario = new FormularioEditUser("User", $opciones); // Créame una instancia hija de Form de tipo FormularioEditUser
		$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Editar Usuario
		
		// Comprueba si eres admin
		if ($_SESSION['isAdmin']) {
			echo '<h1>You are a system administrator!</h1>';
			echo '<form method=POST action="adminSettings.php">
								<input class="button-create" type="submit" value="Admin Settings" />
							</form>';
		}
		?>
	</div>
	<?php
	require("include/comun/footer.php");
	?>
	<script type="text/javascript" src="js/image_preview.js"></script>
</body>

</html>