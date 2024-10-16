<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>

<body>
    <?php
    require 'auxiliar.php';

    $codigo = obtener_post('codigo');
    $denominacion = obtener_post('denominacion');
    $localidad = obtener_post('localidad');
    $pdo = conectar();

    if (isset($codigo, $denominacion, $localidad)) {
        $errores = [];
        comprobar_codigo($codigo, $errores, $pdo);
        comprobar_denominacion($denominacion, $errores, $pdo);
        comprobar_localidad($localidad, $errores, $pdo);


        if (!empty($errores)) {
            mostrar_errores($errores);
        }else {
            $stmt = $pdo->prepare(' INSERT INTO departamentos 
                                    (codigo, denominacion, localidad)
                                    VALUES (:codigo, :denominacion, :localidad)');
            $stmt->execute([
                ':codigo' => $codigo,
                ':denominacion' => $denominacion,
                ':localidad' => $localidad,
            ]);
            setcookie('exito', 'El departamento se ha insertado correctamente');
            volver_departamentos();
            return;
        }
    }
    ?>
    <form action="" method="post">
        <label for="codigo">Código:
            <input type="text" name="codigo" id="codigo" value="<?= $codigo?>">
        </label>
        <br>
        <label for="denominacion">Denominación:
            <input type="text" name="denominacion" id="denominacion" value="<?= $denominacion?>">
        </label>
        <br>
        <label for="localidad">Localidad:
            <input type="text" name="localidad" id="localidad" value="<?= $localidad?>">
        </label>
        <br>
        <button type="submit">Insertar</button>
        <a href="departamentos.php">Volver</a>
    </form>
</body>

</html>
