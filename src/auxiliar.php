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

function hh($cadena)
{
    return htmlspecialchars($cadena ?? '', ENT_QUOTES | ENT_SUBSTITUTE);
}
