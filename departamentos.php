<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>

<body>
    <?php
    require 'auxiliar.php';

    if (isset($_COOKIE['error'])) {
        echo $_COOKIE['error'];
        setcookie('error', '', 1);
    }

    if (isset($_COOKIE['exito'])) {
        echo $_COOKIE['exito'];
        setcookie('exito', '', 1);
    }

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
        $execute[':codigo'] = "$codigo";
    }

    if ($denominacion !== null && $denominacion != '') {
        $where[] = "denominacion ILIKE :denominacion";
        $execute[':denominacion'] = "%$denominacion%";
    }

    if (!empty($where)) {
        $separador = $criterio == 'OR' ? 'OR' : 'AND';
        $where = implode(" $separador ", $where);
        $where = "WHERE $where";
    } else {
        $where = ' ';
    }
    $stmt = $pdo->prepare("     SELECT *
                                FROM departamentos
                                $where
                                ORDER BY codigo");
    $stmt->execute($execute);
    ?>
    <form action="" method="get">
        <label for="codigo">Código:
            <input type="text" name="codigo" value="<?= $codigo ?>">
        </label>
        <label for="denominacion">Denominación:
            <input type="text" name="denominacion" value="<?= $denominacion ?>">
        </label>
        <label for="criterio">Denominación:
            <select name="criterio" id="criterio">
                <?php foreach (CRITERIOS as $value => $texto): ?>
                    <option value="<?= $value ?>" <?= selected($criterio, $value) ?>>
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
                    <td><?= $fila['codigo'] ?></td>
                    <td><?= $fila['denominacion'] ?></td>
                    <td><?= $fila['localidad'] ?></td>
                    <td><?= fecha_formateada($fila['fecha_alta']) ?></td>
                    <td><a href="borrar.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                    <td><a href="modificar.php?id=<?= $fila['id'] ?>">Editar</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="insertar.php">Insertar un nuevo departamento</a>
</body>

</html>
