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

    echo $_COOKIE['error'];

    const CRITERIOS = [
        'AND' => 'Y',
        'OR' => 'O',
    ];

    $codigo = obtener_get('codigo');
    $denominacion = obtener_get('denominacion');
    $criterio = obtener_get('criterio');
    $pdo = conectar();

    $where = [];
    $execute = [];

    if ($codigo !== null && $codigo != '') {
        $where[] = "codigo = :codigo";
        $execute[':codigo'] = $codigo;
    }

    if ($denominacion !== null && $denominacion != '') {
        $where[] = "denominacion ILIKE :denominacion";
        $execute[':denominacion'] = "%$denominacion%";
    }

    if (!empty($where)) {
        $separador = $criterio == 'OR' ? 'OR' : 'AND';
        $where = 'WHERE ' . implode(" $separador ", $where);
    } else {
        $where = '';
    }

    $stmt = $pdo->prepare("SELECT *
                             FROM departamentos
                           $where
                         ORDER BY codigo");
    $stmt->execute($execute);
    ?>
    <form action="" method="get">
        <label>Código:
            <input type="text" name="codigo" value="<?= $codigo ?>" size="3">
        </label>
        <label>Denominación:
            <input type="text" name="denominacion" value="<?= $denominacion ?>">
        </label>
        <label>Criterio:
            <select name="criterio">
                <?php foreach (CRITERIOS as $value => $texto): ?>
                    <option value="<?= $value ?>" <?= selected($criterio, $value) ?> >
                        <?= $texto ?>
                    </option>
                <?php endforeach ?>
            </select>
        </label>

        <button type="submit">Buscar</button>
    </form>
    <br>
    <table border="1">
        <thead>
            <th>Código</th>
            <th>Denominación</th>
            <th>Localidad</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($stmt as $fila): ?>
                <tr>
                    <td><?= $fila['codigo'] ?></td>
                    <td><?= $fila['denominacion'] ?></td>
                    <td><?= $fila['localidad'] ?></td>
                    <td><a href="borrar.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
