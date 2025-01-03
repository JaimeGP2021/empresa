<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css">
    <title>Confirmar borrado</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';
    require '../../src/_menu.php';

    $id = obtener_get('id');

    if (!isset($id)) {
        volver_departamentos();
        return;
    }
    ?>
    <form action="hacer_borrado.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        ¿Está seguro?
        <button type="submit">Sí</button>
        <a href="departamentos.php">No</a>
    </form>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
