<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar un departamento</title>
</head>

<body>
    <?php
    require '../auxiliar/auxiliar.php';

    $id = obtener_get('id');
    $_csrf = obtener_post('_csrf');
    $pdo = conectar();

    if (!($fila = comprobar_id($id, $pdo))) {
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
            if (!isset($_SESSION['_csrf']) || $_SESSION['_csrf'] != $_csrf) {
                $_SESSION['error'] = 'Petición incorecta';
                volver_departamentos();
                return;
            }
            $errores = [];
            comprobar_codigo($codigo, $errores, $pdo, $id);
            comprobar_denominacion($denominacion, $errores);
            comprobar_localidad($localidad, $errores);
            comprobar_fecha_alta($fecha_alta, $errores);


            if (!empty($errores)) {
                mostrar_errores($errores);
            } else {
                $stmt = $pdo->prepare(' UPDATE departamentos
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

    if (!isset($_SESSION['_csrf'])) {
        $_SESSION['csrf'] = bin2hex((random_bytes(32)));
    }
    cabecera();
    ?>
    <form action="" method="post">
        <input type="hidden" name="_csrf" value="<?= $_SESSION['_csrf'] ?>">
        <label for="codigo">Código:
            <input type="text" name="codigo" id="codigo" value="<?= hh($codigo) ?>">
        </label>
        <br>
        <label for="denominacion">Denominación:
            <input type="text" name="denominacion" id="denominacion" value="<?= hh($denominacion) ?>">
        </label>
        <br>
        <label for="localidad">Localidad:
            <input type="text" name="localidad" id="localidad" value="<?= hh($localidad) ?>">
        </label>
        <br>
        <label for="fecha_alta">Fecha de alta:
            <input type="datetime-local" name="fecha_alta" id="fecha_alta" value="<?= hh(fecha_formulario($fecha_alta, true)) ?>">
        </label>
        <br>
        <button type="submit">Modificar</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>

</html>
