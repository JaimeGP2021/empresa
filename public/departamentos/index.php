<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Departamentos</title>
</head>
<body>
    <?php
    require '../../src/auxiliar.php';
    require '../../src/_menu.php';

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
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-12">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
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
                    <th scope="col" class="px-6 py-3" colspan="2">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stmt as $fila): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"><?= hh($fila['codigo']) ?></td>
                        <td class="px-6 py-4"><?= hh($fila['denominacion']) ?></td>
                        <td class="px-6 py-4"><?= hh($fila['localidad']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= hh(fecha_formateada($fila['fecha_alta'])) ?></td>
                        <td class="px-6 py-4"><a href="modificar.php?id=<?= hh($fila['id']) ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Modificar</a></td>
                        <td class="px-6 py-4"><a href="borrar.php?id=<?= hh($fila['id']) ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Borrar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <a href="/departamentos/insertar.php">Insertar un nuevo departamento</a>
    <script src="/js/flowbite/flowbite.js"></script>
</body>
</html>
