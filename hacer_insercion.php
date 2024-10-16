<?php
require 'auxiliar.php';

$codigo = obtener_post('codigo');
$denominacion = obtener_post('denominacion');
$localidad = obtener_post('localidad');

$pdo = conectar();
$stmt = $pdo->prepare(' INSERT INTO departamentos 
                (codigo, denominacion, localidad)
                VALUES (:codigo, :denominacion, :localidad)');
$stmt->execute([
    ':codigo' => $codigo,
    ':denominacion' => $denominacion,
    ':localidad' => $localidad,
]);
setcookie('exito','El departamento se ha insertado correctamente');
volver_departamentos();
