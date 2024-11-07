<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Empleados</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';
    require '../../src/_menu.php';

    $pdo = conectar();
    $stmt = $pdo->query('SELECT e.*, d.codigo, d.denominacion, d.localidad
                           FROM empleados e LEFT JOIN departamentos d
                             ON e.departamento_id = d.id
                       ORDER BY numero');
    ?>
    <table border="1">
        <thead>
            <th>Número</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Código departamento</th>
            <th>Departamento</th>
        </thead>
        <tbody>
            <?php foreach ($stmt as $fila): ?>
                <tr>
                    <td><?= $fila['numero'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td><?= $fila['apellidos'] ?></td>
                    <td><?= $fila['codigo'] ?></td>
                    <td><?= $fila['denominacion'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
