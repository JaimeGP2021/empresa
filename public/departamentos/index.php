<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Departamentos</title>
</head>

<body>
    <?php
    require '../../src/auxiliar.php';

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
        $execute[':codigo'] = "$codigo";
    }

    if ($denominacion !== null && $denominacion != '') {
        $where[] = "denominacion ILIKE :denominacion";
        $execute[':denominacion'] = "%$denominacion%";
    }

    if (!empty($where)) {
        $separador = $criterio == 'OR' ? 'OR' : 'AND';
        $where = 'WHERE ' . implode(" $separador ", $where);
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
            <input type="text" name="codigo" value="<?= hh($codigo) ?>" size="3">
        </label>
        <label for="denominacion">Denominación:
            <input type="text" name="denominacion" value="<?= hh($denominacion) ?>">
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

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-36">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="px-6 py-3">
                    Código
                </th>
                <th scope="col" class="px-6 py-3">
                    Denominación
                </th>
                <th scope="col" class="px-6 py-3">
                    Localidad
                </th>
                <th scope="col" class="px-6 py-3">
                    Alta
                </th>
                <th scope="col" colspan="2" class="px-6 py-3 text-align">
                    Acciones
                </th>
            </tr>
            <tbody>
                <?php foreach ($stmt as $fila): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4"><?= hh($fila['codigo']) ?></td>
                        <td class="px-6 py-4"><?= hh($fila['denominacion']) ?></td>
                        <td class="px-6 py-4"><?= hh($fila['localidad']) ?></td>
                        <td class="px-6 py-4"><?= hh(fecha_formateada($fila['fecha_alta'])) ?></td>
                        <td class="px-6 py-4"><a href="modificar.php?id=<?= hh($fila['id']) ?>">Editar</a></td>
                        <td class="px-6 py-4"><a href="borrar.php?id=<?= hh($fila['id']) ?>">Borrar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <a href="/departamentos/insertar.php">Insertar un nuevo departamento</a>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
