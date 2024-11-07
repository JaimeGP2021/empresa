<?php session_start();

use App\Tablas\Departamento;

require 'vendor/autoload.php';

$id = obtener_post('id');
if (!isset($id)) {
    $_SESSION['error'] = 'Falta el parámetro id';
    volver_departamentos();
    return;
}
$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE empleados IN SHARE MODE');
$departamento = Departamento::por_id($id, $pdo, true);
if ($departamento === null) {
    $_SESSION['error'] = 'El departamento no existe';
    volver_departamentos();
    return;
}
if ($departamento->cantidad_empleados() > 0) {
    $_SESSION['error'] = 'El departamento tiene empleados';
    volver_departamentos();
    return;
}
$departamento->borrar();
$pdo->commit();
$_SESSION['exito'] = 'El departamento se ha borrado correctamente';
volver_departamentos();
