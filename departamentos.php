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

    // $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : null;

    // if (isset($_GET['codigo'])) {
    //     $codigo = trim($_GET['codigo']);
    // } else {
    //     $codigo = null;
    // }

    // $codigo = filter_input(INPUT_GET, 'codigo', FILTER_SANITIZE_NUMBER_INT);

    $denominacion = obtener_get('denominacion');
    $pdo = conectar();

    if ($denominacion == null || $denominacion == '') {
        $where = 'true';
        $execute = [];
    } else {
        $where = "denominacion ILIKE :denominacion";
        $execute = [':denominacion' => "%$denominacion%"];
    }
    $stmt = $pdo->prepare("SELECT *
                             FROM departamentos
                            WHERE $where
                         ORDER BY codigo");
    $stmt->execute($execute);
    ?>
    <form action="" method="get">
        <label>Denominación:
            <input type="text" name="denominacion" value="<?= $denominacion ?>">
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
</body>
</html>
