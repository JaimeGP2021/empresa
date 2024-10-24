<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
</head>
<body>
    <?php
    require '../auxiliar/auxiliar.php';
    
    cabecera();

    $pdo = conectar();
    $stmt = $pdo->query('   SELECT e.*, d.codigo, d.denominacion
                            FROM empleados e LEFT JOIN departamentos d
                            ON e.departamento_id = d.id 
                            ORDER BY numero');
    ?>
    <table border="1">
        <thead>
            <th>Número</th>
            <th>Nombre</th>
            <th>Apellido(s)</th>
            <th>Código Departamento</th>
            <th>Departamento</th>
            <th colspan="2">Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($stmt as $fila): ?>
                <tr>
                    <td><?= hh($fila['numero']) ?></td>
                    <td><?= hh($fila['nombre']) ?></td>
                    <td><?= hh($fila['apellidos']) ?></td>
                    <td><?= hh($fila['codigo']) ?></td>
                    <td><?= hh($fila['denominacion']) ?></td>
                    <td><a href="modificar_empleado.php?id=<?= hh($fila['id']) ?>">Editar</a></td>
                    <td><a href="borrar_empleado.php?id=<?= hh($fila['id']) ?>">Borrar</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="insertar_empleado.php">Insertar un nuevo empleado</a>
</body>
</html>
