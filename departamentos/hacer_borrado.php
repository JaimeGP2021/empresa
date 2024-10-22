<?php
require 'auxiliar.php';

$id = obtener_post('id');
if (!isset($id)) {
    setcookie('error', 'Falta el parámetro id');
    volver();
    return;
}
$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE empleados IN SHARE MODE');
$fila = departamento_por_id($id, $pdo, true);
if ($fila === false) {
    setcookie('error', 'El departamento no existe');
    volver();
    return;
}
$stmt = $pdo->prepare('SELECT COUNT(*)
                         FROM empleados
                        WHERE departamento_id = :id');
$stmt->execute([':id' => $id]);
$cuantos = $stmt->fetchColumn();
if ($cuantos > 0) {
    setcookie('error', 'El departamento tiene empleados');
    volver();
    return;
}
$stmt = $pdo->prepare('DELETE FROM departamentos
                             WHERE id = :id');
$stmt->execute([':id' => $id]);
$pdo->commit();
setcookie('exito', 'El departamento se ha borrado correctamente');
volver();
