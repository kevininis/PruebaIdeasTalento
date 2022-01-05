<?php
    session_start();

    require 'database.php';

    if (isset($_SESSION['userId'])) {
        $records = $conn->prepare('SELECT userId, user_name, password FROM user WHERE userId = :userId');
        $records->bindParam(':userId', $_SESSION['userId']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $user = null;

        if (count($results) > 0){
            $user = $results;
        }
    } 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Inicio</title>
</head>
<body>
    <?php require './otrasVistas/header.php' ?>

    <?php if (!empty($user)): ?>
        <br> Bienvenido <?= $user['user_name'] ?>
        <br>Has sido logueado satisfactoriamente
        <a href="logout.php">Cerrar sesión</a>
    <?php else: ?>

    <h3 class="inicio">Por favor <a href="login.php">ingresa</a> o <a href="register.php">registrate</a></h3>
    <?php endif; ?>
</body>
</html>