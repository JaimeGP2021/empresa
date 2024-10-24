<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>

<body>
    <?php
    require '../auxiliar/auxiliar.php';

    if (!es_admin()) {
        $_SESSION['error'] = 'No tiene permisos suficientes.';
        volver_departamentos();
        return;
    }
    
    cabecera();

    $codigo = obtener_post('codigo');
    $denominacion = obtener_post('denominacion');
    $localidad = obtener_post('localidad');
    $fecha_alta = obtener_post('fecha_alta');
    $pdo = conectar();

    if (isset($codigo, $denominacion, $localidad, $fecha_alta)) {
        $errores = [];
        comprobar_codigo($codigo, $errores, $pdo);
        comprobar_denominacion($denominacion, $errores, $pdo);
        comprobar_localidad($localidad, $errores);
        comprobar_fecha_alta($fecha_alta, $errores);

        if (!empty($errores)) {
            mostrar_errores($errores);
        } else {
            $stmt = $pdo->prepare(' INSERT INTO departamentos 
                                    (codigo, denominacion, localidad, fecha_alta)
                                    VALUES (:codigo, :denominacion, :localidad, :fecha_alta)');
            $stmt->execute([
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
        <label for="fecha_alta">Fecha de alta:
            <input type="datetime-local" name="fecha_alta" id="fecha_alta" value="<?= fecha_formulario($fecha_alta, true)?>">
        </label>
        <br>
        <button type="submit">Insertar</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>

</html>
