<?php
require '../auxiliar/auxiliar.php';

$id = obtener_post('id');
if (!isset($id)) {
    setcookie('error', 'Falta el parámetro id');
    volver();
    return;
}
$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE empleados IN SHARE MODE');
$fila = empleado_por_id($id, $pdo, true);
if ($fila == false) {
    setcookie('error', 'El empleado no existe');
    volver();
    return;
}
$stmt = $pdo->prepare(' DELETE FROM empleados
                        WHERE id = :id');
$stmt->execute([':id' => $id]);
$pdo->commit();
setcookie('exito', 'El empelado se ha borrado correctamente');
volver();
