<?php 
    require './database.php';

    $message = '';

    if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
        $rolId = 1;
        $user_name = $_POST['user_name'];
        $firtsName = $_POST['firtsName'];
        $lastName  = $_POST['lastName'];
        $status = 'Activo';
        $password  = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $date      = date("Y-m-d", time());


        $sql = "INSERT INTO user (roleId, user_name, firtsName, lastName, status, password, createUser, createDate) VALUES (:rolId, :user_name, :firtsName, :lastName, :status, :password, :createUser, :createDate)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':rolId', $rolId);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':firtsName', $firtsName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':createUser', $user_name);
        $stmt->bindParam(':createDate', $date);

        if ($stmt->execute()) {
            $message = 'Usuario creado satisfactoriamente';
        } else {
            $message = 'Ha ocurrido un error al crear el usuario';
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
    <title>Login</title>
</head>
<body>
    <?php require './otrasVistas/header.php' ?>

    <?php if (!empty($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form class="login-form" action="register.php" method="POST">
        <h3>Registrate</h3><br>
            <span>Nombre</span><br>
            <input type="text" name="firtsName" placeholder="Nombre"><br>
            <span>Apellido</span><br>
            <input type="text" name="lastName" placeholder="Apellido"><br>
            <span>Usuario</span><br>
            <input type="text" name="user_name" placeholder="Usuario"><br>
            <span>Contraseña</span><br>
            <input type="password" name="password" placeholder="Contraseña"><br>
        <input type="submit" value="Registrarse">
    </form><br>
    <span>o <a href="login.php">Inicia sesión</a></span>
</body>
</html>