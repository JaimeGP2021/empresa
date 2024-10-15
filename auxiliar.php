<?php

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=datos', 'datos', 'datos');
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

function volver_departamentos()
{
    header('Location: departamentos.php');
}

function obtener_departamento($id, ?PDO $pdo = null, $bloqueo = false): array|false
{
    $pdo = $pdo ?? conectar();
    $sql = 'SELECT * FROM departamentos WHERE id = :id';
    if ($bloqueo) {
        $sql .= ' FOR UPDATE';
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}
