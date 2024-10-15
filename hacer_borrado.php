<?php
require 'auxiliar.php';

$id = obtener_post('id');
if (!isset($id)) {
    volver_departamentos();
    return;
}
$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE empleados IN SHARE MODE');
$fila = obtener_departamento($id, $pdo, true);
if ($fila == false) {
    volver_departamentos();
    return;
}
$stmt = $pdo->prepare('SELECT COUNT(*)
                        FROM empleados
                        WHERE departamento_id =:id');
$stmt->execute([':id' => $id]);
$cuantos = $stmt->fetchColumn();
if ($cuantos > 0) {
    volver_departamentos();
    return;
}

$stmt = $pdo->prepare(' DELETE FROM departamentos
                        WHERE id = :id');
$stmt->execute([':id' => $id]);
$pdo->commit();
volver_departamentos();
