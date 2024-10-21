<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo empleado</title>
</head>

<body>
    <?php
    require 'auxiliar.php';

    $numero = obtener_post('numero');
    $nombre = obtener_post('nombre');
    $apellidos = obtener_post('apellidos');
    $departamento_id = obtener_post('departamento_id');
    $pdo = conectar();

    if (isset($numero, $nombre, $apellidos, $departamento_id)) {
        $errores = [];
        comprobar_numero($numero, $errores, $pdo);
        comprobar_nombre($nombre, $errores, $pdo);
        comprobar_apellidos($apellidos, $errores);
        comprobar_departamento_id($departamento_id, $errores);


        if (!empty($errores)) {
            mostrar_errores($errores);
        } else {
            $stmt = $pdo->prepare(' INSERT INTO empleados 
                                    (numero, nombre, apellidos, departamento_id)
                                    VALUES (:numero, :nombre, :apellidos, :departamento_id)');
            $stmt->execute([
                ':numero' => $numero,
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':departamento_id' => $departamento_id,
            ]);
            setcookie('exito', 'El departamento se ha insertado correctamente');
            volver_empleados();
            return;
        }
    }
    ?>
    <form action="" method="post">
        <label for="numero">Código:
            <input type="text" name="numero" id="numero" value="<?= $numero?>">
        </label>
        <br>
        <label for="nombre">Nombre:
            <input type="text" name="nombre" id="nombre" value="<?= $nombre?>">
        </label>
        <br>
        <label for="apellidos">Apellidos:
            <input type="text" name="apellidos" id="apellidos" value="<?= $apellidos?>">
        </label>
        <br>
        <label for="departamento_id">Departamento:
            <input type="select" name="departamento_id" id="departamento_id">
                <?php foreach ($departamento_id as $id_departamento) {
                    ?><option value="<?=$id_departamento?>"><?php nombre_departamento_por_id($id_departamento)?></option> 
                    <?php }?>
                ?> 
        </label>
        <br>
        <button type="submit">Insertar</button>
        <a href="empleados.php">Volver</a>
    </form>
</body>

</html>
