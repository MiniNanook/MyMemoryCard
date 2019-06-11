<?php
	require_once __DIR__.'/include/Aplicacion.php';
	require_once __DIR__.'/include/config.php';
	require_once __DIR__.'/include/FormularioGame.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Add a Game</title>
	<link rel="stylesheet" type="text/css" href="css/perfil.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/game-images.css">
	<link rel="stylesheet" type="text/css" href="css/content.css">
	<link rel="stylesheet" href="css/game-page.css">
</head>
	<?php
		require("include/comun/header.php");
    ?>
	<div class="content">
		<?php
			$opciones = array(); // Ninguna por defecto
			$formulario = new FormularioGame("Game", $opciones); // Créame una instancia hija de Form de tipo añadir Juego
			$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo añadir Juego
		?>
	</div>
	<div>
	<?php
		require("include/comun/footer.php");
  ?>
	<script type="text/javascript" src="js/image_preview.js"></script>
</body>
</html>
