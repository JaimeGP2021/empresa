<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Modificar un departamento</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';
    require '../../src/_menu.php';

    use App\Tablas\Departamento;

    $id = obtener_get('id');
    $pdo = conectar();

    if (!($fila = Departamento::comprobar_id($id, $pdo))) {
        $_SESSION['error'] = 'Error al recuperar el departamento';
        volver_departamentos();
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $codigo = obtener_post('codigo');
        $denominacion = obtener_post('denominacion');
        $localidad = obtener_post('localidad');
        $fecha_alta = obtener_post('fecha_alta');

        if (isset($codigo, $denominacion, $localidad, $fecha_alta)) {
            $errores = [];
            Departamento::comprobar_codigo($codigo, $errores, $pdo, $id);
            Departamento::comprobar_denominacion($denominacion, $errores, $pdo);
            Departamento::comprobar_localidad($localidad, $errores);
            Departamento::comprobar_fecha_alta($fecha_alta, $errores);

            if (!empty($errores)) {
                mostrar_errores($errores);
            } else {
                $stmt = $pdo->prepare('UPDATE departamentos
                                          SET codigo = :codigo,
                                              denominacion = :denominacion,
                                              localidad = :localidad,
                                              fecha_alta = :fecha_alta
                                        WHERE id = :id');
                $stmt->execute([
                    ':id' => $id,
                    ':codigo' => $codigo,
                    ':denominacion' => $denominacion,
                    ':localidad' => $localidad,
                    ':fecha_alta' => $fecha_alta,
                ]);
                $_SESSION['exito'] = 'El departamento se ha insertado correctamente';
                volver_departamentos();
                return;
            }
        }
    } else {
        $codigo = $fila['codigo'];
        $denominacion = $fila['denominacion'];
        $localidad = $fila['localidad'];
        $fecha_alta = $fila['fecha_alta'];
    }

    ?>
    <form action="" class="max-w-sm mx-auto mt-4" method="post">
        <div class="mb-5">
            <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código</label>
            <input type="text" id="codigo" name="codigo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                value="<?= hh($codigo) ?>" required />
        </div>
        <div class="mb-5">
            <label for="denominacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Denominación</label>
            <input type="text" id="denominacion" name="denominacion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                value="<?= hh($denominacion) ?>" required />
        </div>
        <div class="mb-5">
            <label for="localidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Localidad</label>
            <input type="text" id="localidad" name="localidad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                value="<?= hh($localidad) ?>" required />
        </div>
        <div class="mb-5">
            <label for="fecha_alta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de alta</label>
            <input type="datetime-local" id="fecha_alta" name="fecha_alta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                value="<?= hh(fecha_formulario($fecha_alta, true)) ?>" required />
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Modificar</button>
        <a href="/departamentos/" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Cancelar</a>
    </form>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
