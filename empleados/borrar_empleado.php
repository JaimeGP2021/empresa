<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Borrado</title>
</head>

<body>
    <?php
    require '../auxiliar/auxiliar.php';
    cabecera();

    $id = obtener_get('id');
    $_csrf = obtener_post('_csrf');

    if (isset($codigo, $denominacion, $localidad, $fecha_alta)) {
        if (!isset($_SESSION['_csrf']) || $_SESSION['_csrf'] != $_csrf) {
            $_SESSION['error'] = 'Petición incorecta';
            volver_departamentos();
            return;
        }
    }

    if (!isset($id)) {
        volver_empleados();
        return;
    }

    if (!isset($_SESSION['_csrf'])) {
        $_SESSION['csrf'] = bin2hex((random_bytes(32)));
    }
    ?>
    <form action="hacer_borrado_empleado.php" method="post">
        <input type="hidden" name="_csrf" value="<?= $_SESSION['_csrf'] ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        ¿Estás seguro?
        <button type="submit">Sí</button>
        <a href="index.php">No</a>
        </label>
    </form>
</body>

</html>
