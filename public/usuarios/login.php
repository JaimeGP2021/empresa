<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Login</title>
</head>
<body>
    <?php
    require 'vendor/autoload';
    require '../../src/_menu.php';

    use App\Tablas\Usuario;

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
    <script src="/js/flowbite/flowbite.js"></script>
</body>
</html>
