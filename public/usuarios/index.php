<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Usuarios</title>
</head>

<body>
    <?php
    require 'vendor/autoload';
    require '../../src/_menu.php';

    use App\Tablas\Usuario;

    const CRITERIOS = [
        'AND' => 'Y',
        'OR' => 'O',
    ];

    $username = obtener_get('username');
    $criterio = obtener_get('criterio');
    $pdo = conectar();

    $where = [];
    $execute = [];

    if ($username !== null && $username != '') {
        $where[] = "username ILIKE :username";
        $execute[':username'] = "%$username%";
    }

    // $stmt = $pdo->prepare("SELECT *
    //                          FROM usuarios
    //                        $where
    //                      ORDER BY username");
    // $stmt->execute($execute);
    $usuarios = Usuario::todos($where, $execute, $pdo);
    ?>
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <form action="" method="get">
            <label>Username:
                <input type="text" name="username" value="<?= hh($username) ?>">
            </label>
            <label>Criterio:
                <select name="criterio">
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
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-12">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-3" colspan="2">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"><?= hh($usuario->username) ?></td>
                            <td class="px-6 py-4"><a href="modificar.php?id=<?= hh($usuario->id) ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Modificar</a></td>
                            <td class="px-6 py-4"><a href="borrar.php?id=<?= hh($usuario->id) ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Borrar</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
