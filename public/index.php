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
    require '../src/auxiliar.php';

    cabecera();
    ?>
    <div class="h-64">
            <div class="p-4 m-4 bg-green-600">
                <h1 class="text-2xl font-bold text-white">Tailwind CSS Demo</h1>
            </div>
            <div class="p-4 m-4 bg-green-300 h-full">
                <h2 class="text-green-900">Have much fun using Tailwind CSS</h2>
            </div>
        </div>
    <ul>
        <li><a href="empleados">Empleados</a></li>
        <li><a href="departamentos">Departamentos</a></li>
        <li><a href="usuarios/login.php">Login</a></li>
    </ul>
</body>
</html>
