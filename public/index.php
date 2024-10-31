<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Menú principal</title>
</head>

<body>
    <?php
    require '../src/auxiliar.php';

    require '../src/views/_menu.php';
    ?>
    <h1>Benvenuto</h1>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
