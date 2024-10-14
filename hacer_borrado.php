<?php
require 'auxiliar.php';

$id= obtener_post('id');
$pdo = conectar();
$stmt = $pdo->prepare(' DELETE FROM departamentos
                        WHERE id = :id');
$stmt->execute([':id' => $id]);
header('Location: departamentos.php');
