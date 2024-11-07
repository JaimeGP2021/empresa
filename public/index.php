<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Menú principal</title>
</head>
<body>
    <?php
    require '../vendor/autoload.php';
    require '../src/_menu.php';
    ?>
    <ul>
        <li><a href="empleados">Empleados</a></li>
        <li><a href="departamentos">Departamentos</a></li>
        <li><a href="usuarios/login.php">Login</a></li>
    </ul>
    <script src="/js/flowbite/flowbite.js"></script>
</body>
</html>
