<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    require '../../src/auxiliar.php';

    $username = obtener_post('username');
    $password = obtener_post('password');

    if (isset($username, $password)) {
        $pdo = conectar();
        $usuario = usuario_por_username($username, $pdo);
        if ($usuario !== false) {
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['login'] = $username;
                volver_empleados();
            }
        }
        $_SESSION['error'] = 'Fallo de autenticación';
    }

    cabecera();
    ?>
    <form action="" method="post">
        <label>
            Usuario:
            <input type="text" name="username">
        </label>
        <br>
        <label>
            Contraseña:
            <input type="password" name="password">
        </label>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
