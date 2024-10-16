<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>
<body>
    <form action="hacer_insercion.php" method="post">
        <label for="codigo">Código:
            <input type="text" name="codigo" id="codigo">
        </label>
        <br>
        <label for="denominacion">Denominación:
            <input type="text" name="denominacion" id="denominacion">
        </label>
        <br>
        <label for="localidad">Localidad:
            <input type="text" name="localidad" id="localidad">
        </label>
        <br>
        <button type="submit">Insertar</button>
        <a href="departamentos.php">Volver</a>
    </form>
</body>
</html>
