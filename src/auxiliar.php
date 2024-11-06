<?php

function conectar()
{
    try {
        return new PDO('pgsql:host=localhost;dbname=datos', 'datos', 'datos');
    } catch (PDOException $e) {
        return false;
    }
}

function obtener_get($par) {
    return isset($_GET[$par]) ? trim($_GET[$par]) : null;
}

function obtener_post($par) {
    return isset($_POST[$par]) ? trim($_POST[$par]) : null;
}

function selected($criterio, $valor)
{
    return $criterio == $valor ? 'selected' : '';
}

function volver()
{
    header('Location: /');
}

function volver_empleados()
{
    header('Location: /empleados/');
}

function volver_departamentos()
{
    header('Location: /departamentos/');
}

function anyadir_error($par, $mensaje, &$errores)
{
    if (!isset($errores[$par])) {
        $errores[$par] = [];
    }
    $errores[$par][] = $mensaje;
}

function comprobar_denominacion($denominacion, &$errores)
{
    if ($denominacion == '') {
        anyadir_error('denominacion', 'La denominación no puede estar vacía', $errores);
    } elseif (mb_strlen($denominacion) > 255) {
        anyadir_error('denominacion', 'La denominación es demasiado larga', $errores);
    }
}

function comprobar_localidad(&$localidad, &$errores)
{
    if ($localidad == '') {
        $localidad = null;
    } elseif (mb_strlen($localidad) > 255) {
        anyadir_error('localidad', 'La localidad es demasiado larga', $errores);
    }
}

function comprobar_id($id, ?PDO $pdo = null): array|false
{
    $pdo = $pdo ?? conectar();
    if (!isset($_GET['id'])) {
        return false;
    }
    $id = trim($_GET['id']);
    if (!ctype_digit($id)) {
        return false;
    }
    $stmt = $pdo->prepare('SELECT *
                             FROM departamentos
                            WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function mostrar_errores($errores)
{
    foreach ($errores as $par => $mensajes) {
        foreach ($mensajes as $mensaje) { ?>
            <h2><?= $mensaje ?></h3><?php
        }
    }
}

function fecha_formateada($fecha, $incluir_hora = false)
{
    $fecha = new DateTime($fecha);
    $fecha->setTimezone(new DateTimeZone('Europe/Madrid'));
    if ($incluir_hora) {
        return $fecha->format('d-m-Y H:i:s');
    }
    return $fecha->format('d-m-Y');
}

function fecha_formulario($fecha, $incluir_hora = false)
{
    $fecha = new DateTime($fecha);
    $fecha->setTimezone(new DateTimeZone('Europe/Madrid'));
    if ($incluir_hora) {
        return $fecha->format('Y-m-d H:i:s');
    }
    return $fecha->format('Y-m-d');
}

function boton_logout()
{ ?>
    <?php
}

function cabecera()
{
    if (Usuario::esta_logueado()) { ?>
        <form style="float: right" action="/usuarios/logout.php" method="post">
            <?= Usuario::logueado()->username ?>
            <button type="submit">Logout</button>
        </form>
        <a href="/">Aplicación de gestión de empleados</a>
        <hr style="margin-bottom: 1em;"><?php
    }

    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['exito'])) {
        echo $_SESSION['exito'];
        unset($_SESSION['exito']);
    }
}

function hh($cadena)
{
    return htmlspecialchars($cadena ?? '', ENT_QUOTES | ENT_SUBSTITUTE);
}
