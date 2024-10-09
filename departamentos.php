<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    $pdo = conectar();
    $stmt = $pdo->query('SELECT *
                           FROM departamentos
                       ORDER BY codigo');
    ?>
    <table border="1">
        <thead>
            <th>Código</th>
            <th>Denominación</th>
            <th>Localidad</th>
        </thead>
        <tbody>
            <?php foreach ($stmt as $fila): ?>
                <tr>
                    <td><?= $fila['codigo'] ?></td>
                    <td><?= $fila['denominacion'] ?></td>
                    <td><?= $fila['localidad'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <!-- // $filas = $stmt->fetchAll();
    // foreach ($filas as $fila) {
    //     var_dump($fila);
    // }
    // while ($fila = $stmt->fetch()) {
    //     var_dump($fila);
    // } -->
</body>
</html>
