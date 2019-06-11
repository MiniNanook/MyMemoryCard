<?php
	require_once __DIR__.'/include/Aplicacion.php';
	require_once __DIR__.'/include/config.php';
	require_once __DIR__.'/include/FormularioMensaje.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Send Message</title>
	<link rel="stylesheet" type="text/css" href="css/perfil.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/game-images.css">
	<link rel="stylesheet" type="text/css" href="css/content.css">
</head>
	<?php
		require("include/comun/header.php");
    ?>
	<div class="content">
		<?php
			$opciones = array(); // Ninguna por defecto
			$formulario = new FormularioMensaje("Mensaje", $opciones); // Créame una instancia hija de Form de tipo Mensaje
			$formulario->gestiona(); // Búscame el HTML correspondiente al formulario de tipo Mandar Mensaje
		?>
	</div>
	<div>
	<?php
		require("include/comun/footer.php");
    ?>
</body>
</html>
