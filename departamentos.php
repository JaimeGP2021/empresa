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

    // if (isset($_GET['codigo'])) {
    //     $codigo = trim($_GET['codigo']);
    // } else {
    //     $codigo = null;
    // }

    $codigo = obtener_get('codigo');
    $pdo = conectar();

    if ($codigo == null || $codigo == '') {
        $where = 'true';
        $execute = [];
    } else {
        $where = 'codigo = :codigo';
        $execute = [':codigo' => $codigo];
    }
    $stmt = $pdo->prepare(" SELECT *
                                FROM departamentos
                                WHERE $where
                                ORDER BY codigo");
    $stmt->execute($execute);
    ?>
    <form action="" method="get">
        <label for="codigo">Código:
            <input type="text" name="codigo" value="<?= $codigo ?>">
        </label>
        <button type="submit">Buscar</button>
    </form>
    <br>
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
