<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>
<body>
    <?php
    require '../auxiliar/auxiliar.php';

    cabecera();

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
            <input type="text" name="codigo" value="<?= hh($codigo) ?>" size="3">
        </label>
        <label>Denominación:
            <input type="text" name="denominacion" value="<?= hh($denominacion) ?>">
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
            <th>Alta</th>
            <th colspan="2">Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($stmt as $fila): ?>
                <tr>
                    <td><?= hh($fila['codigo']) ?></td>
                    <td><?= hh($fila['denominacion']) ?></td>
                    <td><?= hh($fila['localidad']) ?></td>
                    <td><?= hh(fecha_formateada($fila['fecha_alta'])) ?></td>
                    <td><a href="modificar.php?id=<?= hh($fila['id']) ?>">Modificar</a></td>
                    <td><a href="borrar.php?id=<?= hh($fila['id']) ?>">Borrar</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="/departamentos/insertar.php">Insertar un nuevo departamento</a>
</body>
</html>
