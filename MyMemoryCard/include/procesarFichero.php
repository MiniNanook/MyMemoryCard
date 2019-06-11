<?php
	session_start();

	$savename=$_SESSION["username"];

	unlink('../usuarios/'.$savename.'.jpg');
	unlink('../usuarios/'.$savename.'.png');

	move_uploaded_file($_FILES["file"]["tmp_name"], "../usuarios/".$_FILES["file"]["name"]);
	if($_FILES["file"]["type"]=="image/png"){
		rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.png');
	} else if($_FILES["file"]["type"]=="image/jpeg"){
		rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.jpg');
	} else if($_FILES["file"]["type"]=="image/jpg"){
			rename('../usuarios/'.$_FILES["file"]["name"], '../usuarios/'.$savename.'.jpg');
	} else echo "Image form error.";
	
	header('Location: ../perfilOwner.php');
	exit();

?>