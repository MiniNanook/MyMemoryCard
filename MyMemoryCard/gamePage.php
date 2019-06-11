<?php
	require_once __DIR__.'/include/loadGame.php'; // Script que carga el juego en una variable para visualizar su perfil
	require_once __DIR__.'/include/config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Game Page</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/content.css">
	<link rel="stylesheet" href="css/game-page.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css"/>
</head>
<body>
	<?php
		require("include/comun/header.php");
	?>

	<div class="content">
		<?php
			// Imagen
			echo '<div class="game-title">';
				echo '<h1>'.$game->title().'</h1>';
			echo '</div>';
			$platform = str_replace(" ", "/", $game->platform()); // En caso de que tenga espacios
			echo '<img class="cover-img" src="img/games/'.$game->company().'/'.$platform.'/'.$game->id().'.jpg" class="preview" id="output"/>';
			echo '<h2>Company: '.$game->company();
			echo '<h2>Platform: '.$game->platform().'</h2>';
			echo '<h2>Release Date: '.$game->year().'</h2>';
			echo '<h2>'.$game->average().'</h2>';
			echo '<h3>Genres: '.$game->genresString().'</h3>';
			// Actualiza o añade dependiendo de si ya tienes o no el juego añadido en tu lista
			if (isset($listed) && $listed) echo '<form action="include/updateList.php" method="POST">';
			else echo '<form action="include/addToMyList.php" method="POST">';
		?>
			<?php echo '<input type="hidden" name="game" value="'.$game->id().'">'?>
			Score: <select class="form-control" id="score" type="text" name="score">
				<option value="-">-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>
			Status: <select class="form-control" id="status" type="text" name="status" required>
				<?php 
				if ($listed) {
					echo '<option value="'.$listed['status'].'">'.$listed['status'].'</option>';
				}
				?>
				<option value="Want to Play">Want to Play</option>
				<option value="Playing">Playing</option>
				<option value="Finished">Finished</option>
				<option value="Played">Played</option>
			</select>
			<p></p>
			<?php
				if (!$listed || $listed['isFavourite'] == 0) {
					echo '<input type="checkbox" name="favourite" value="favourite">Add to Favourites<br>';
				} else if ($listed['isFavourite'] == 1) {
					echo '<input type="checkbox" name="favourite" value="favourite" checked>Is already favourite<br>';
				}
				if (isset($listed) && $listed) echo '<input type="submit" value="Update">';
				else echo '<input type="submit" value="Add to my List">';
			?>
			<p></p>
		</form>

		<?php
			if (isset($listed) && $listed) echo '<form action="include/deleteFromList.php" method="POST">
				<input type="hidden" name="id" value="'.$game->id().'">
				<input type="submit" value="Delete from your list"/>
			</form>';
		?>

		<?php

			// Ahora imprime todas las reviews del juego
			if (!$allReviews) { // Aún no hay ninguna review
				echo 'Nobody has reviewed this game yet...'; // Imprime la review que has hecho
				echo '<form action="gameReview.php" method="POST">
					<input type="hidden" name="gameId" value="'.$game->id().'">
					<input type="hidden" name="type" value="change">
					<input type="submit" value="Be the first!"/>
				</form>';
			} else { // Imprime todas las reviews
				if ($reviewed) { // Si ya has hecho una review del juego, solo te permite modificarla
					echo 'Your review on the game: '; // Imprime la review que has hecho
					echo '<form action="gameReview.php" method="POST">
						<input type="hidden" name="gameId" value="'.$game->id().'">
						<input type="hidden" name="type" value="change">
						<input type="submit" value="Change review"/>
					</form>';
				} else { // Añade una review
					echo 'You haven\'t reviewed this game yet!';
					echo '<form action="gameReview.php" method="POST">
						<input type="hidden" name="gameId" value="'.$game->id().'">
						<input type="submit" value="Write a review"/>
					</form>';
				}
				echo '<h1 class="review" id="title">Reviews</h1>';
				echo '<div class="multiple-items">';
				while ($row = $allReviews->fetch_assoc()) {
					echo '<div class="review" id="text">';
						$user = Usuario::buscaUsuarioId($row['idUser']);
						echo '<h1>Review By: '.$user->username().'</h1>
						<h2>Score: '.$row['score'].'/10</h2>
						<p>'.$row['review'].'</p>
						<h4>at: '.$row['time'].'</h4>';
					echo '</div>';
				}
				echo '</div>';
			}			
		?>

		<?php
			// En caso de que seas admin, se te permite modificar los datos del juego
			if ($_SESSION['isAdmin']) {
				echo '<div class="game-admin-options">';
					echo '<h1>You are a system administrator!</h1>';
					echo '<h1><a href="changeGame.php?id='.$game->id().'">Change Game</a></h1>';
				echo '</div>';
			}
		?>


	</div>
	<?php
		require("include/comun/footer.php");
	?>
</body>
<script>
	// La razón por la que dejo este script aquí es por que necesito usar PHP
	window.onload = function() {
		document.getElementById('score').selectedIndex=<?php echo $listed['rating']; ?>;
	}
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="css/slick/slick/slick.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.multiple-items').slick({
			infinite: true,
			slidesToShow: 3,
			slidesToScroll: 3,
			autoplay: true,
			autoplaySpeed: 3000,
			dots: true,
			speed: 700,
			arrows: true
		});
	});
</script>
</html>