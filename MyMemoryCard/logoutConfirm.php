<?php
    require_once __DIR__.'\include\config.php';

    if (!isset($_SESSION['login']) && !$_SESSION['login'] === true) {
        header("Location: signup.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Out</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>Are you sure you want to Log Out?</h1>
        <div class="logout">
            <a href="include/logout.php"><button class="logout-button" type="button">Yes</button></a>
            <a href="index.php"><button class="logout-button" type="button">No</button></a>
        </div>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>