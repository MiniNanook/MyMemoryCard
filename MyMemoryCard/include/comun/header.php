<div class="header">
	
	<?php if (isset($_SESSION['user'])) { ?>
		<a href="index.php"><img src="img/logo-header.png" alt="logo" class="logo"></a>
		<nav id="left">
			<ul>
				<li><a href="index.php">Home</a></li>
				<?php 
					echo '<li><a href="userProfile.php?id='.$_SESSION['user']->id().'">Profile</a></li>'; 
				?>
				<li><a href="search.php">Search</a></li>
				<?php
					if ($_SESSION['isAdmin']) {
						echo '<li><a href="addGame.php">Add Game</a></li>';
					}
				?>
			</ul>
		</nav>
		<nav id="right">
			<ul>
				<li>
					<a href="userSettings.php">Settings</a>
				</li>	
				<li><?php
				if (isset($_SESSION["username"]) && ($_SESSION["login"]===true)) {
					echo '<a href="logoutConfirm.php">Logout</a>';
				} else {
					echo '<a href="signup.php">Login/Register</a>';
				}
				?></a></li>
			</ul>
		</nav>
	<?php } else { ?>
		<img src="img/logo-header.png" alt="logo" class="logo">
		<nav id="right">
			<ul>
				<li><a href="signup.php">Login/Register</a></li>
			</ul>
		</nav>
	<?php } ?>
	
</div>














