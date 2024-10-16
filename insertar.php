<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>
<body>
    <form action="hacer_insercion.php" method="post">
        <label>
            Código:
            <input type="text" name="codigo">
        </label>
        <br>
        <label>
            Denominación:
            <input type="text" name="denominacion">
        </label>
        <br>
        <label>
            Localidad:
            <input type="text" name="localidad">
        </label>
        <br>
        <button type="submit">Insertar</button>
        <a href="departamentos.php">Cancelar</a>
    </form>
</body>
</html>
