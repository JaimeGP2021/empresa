<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú principal</title>
</head>

<body>
    <?php
    require 'auxiliar/auxiliar.php';

    cabecera();
    ?>
    <ul>
        <li><a href="empleados">Empleados</a></li>
        <li><a href="departamentos">Departamentos</a></li>
        <li><a href="usuarios/login.php">Login</a></li>
    </ul>
</body>

</html>
