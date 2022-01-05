<?php
    session_start();

    require 'database.php';

    $intentos = 0;
    
    if ($intentos < 3) {
        if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
            $records = $conn->prepare("SELECT userId, user_name, password FROM user WHERE user_name = :user_name AND status = 'Activo'");
            $records->bindParam(':user_name', $_POST['user_name']);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
            
            $message = '';
    
            if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
                $_SESSION['userId'] = $results['userId'];
                header('Location: /SoftwareLoginConPHPyMySQL');
            } else {
                $message = 'Las credenciales no coinciden';
                $intentos = $intentos + 1;
                print($intentos);
            }
        }
    } else {
        $bloqueo = $conn->prepare("UPDATE user SET status = 'Bloqueado' WHERE user_name = :user_name");
        $bloqueo->bindParam(':user_name', $_POST['user_name']);
        $bloqueo->execute();

        $message = 'Este usuario ha sido bloqueado';
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
    <form class="login-form" action="login.php" method="POST">
        <p>Iniciar sesión</p>
        <input type="text" name="user_name" placeholder="Usuario"><br>
        <input type="password" name="password" placeholder="Contraseña"><br>
        <input type="submit" value="Ingresar">
    </form>
    <span>o <a href="register.php">Registrarse</a></span>

</body>
</html>