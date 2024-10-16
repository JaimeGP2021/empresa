<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Borrado</title>
</head>

<body>
    <?php
    require 'auxiliar.php';

    $id = obtener_get('id');

    if (!isset($id)) {
        volver_departamentos();
        return;
    }
    ?>
    <form action="hacer_borrado.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        ¿Estás seguro?
        <button type="submit">Sí</button>
        <a href="departamentos.php">No</a>
        </label>
    </form>
</body>

</html>
