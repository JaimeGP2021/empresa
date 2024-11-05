<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    require '../../src/auxiliar.php';
    require '../../src/Usuario.php';

    $username = obtener_post('username');
    $password = obtener_post('password');

    if (isset($username, $password)) {
        $usuario = Usuario::por_username($username);
        if ($usuario !== null) {
            if ($usuario->comprobar_password($password)) {
                $_SESSION['login'] = serialize($usuario);
                volver_departamentos();
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
