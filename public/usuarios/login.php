<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Login</title>
</head>

<body>
    <?php
    require '../../src/auxiliar.php';
    require '../../src/Usuario.php';
    require '../../src/views/_menu.php';

    $username = obtener_post('username');
    $password = obtener_post('password');
    $_csrf = obtener_post('_csrf');

    if (isset($username, $password)) {
        if (!isset($_SESSION['_csrf']) || $_SESSION['_csrf'] != $_csrf) {
            $_SESSION['error'] = 'Petición incorrecta.';
            volver();
            return;
        }
        $pdo = conectar();
        $usuario = usuario_por_username($username, $pdo);
        if ($usuario !== false) {
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['login'] = serialize(new Usuario($usuario));
                volver();
            }
        }
        $_SESSION['error'] = 'Fallo de autenticación';
    }
    if (!isset($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    ?>
    <form action="" method="post">
        <input type="hidden" name="_csrf" value="<?= $_SESSION['_csrf'] ?>">
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
