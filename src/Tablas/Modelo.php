<?php

namespace App\Tablas;

use PDO;

class Modelo
{
    protected static string $tabla;
    protected static string $orden_defecto;

    public static function todos(
        array $where = [],
        array $execute = [],
        ?PDO $pdo = null,
        string $criterio = 'AND',
        ?string $orden = null,
    ): array
    {
        $pdo = $pdo ?? conectar();
        $where = !empty($where) ? 'WHERE ' . implode(" $criterio ", $where) : '';
        $orden = $orden ?? static::$orden_defecto;
        $execute[':orden'] = $orden;
        $tabla = static::$tabla;
        $stmt = $pdo->prepare("SELECT *
                                 FROM $tabla
                               $where
                             ORDER BY :orden");
        $stmt->execute($execute);
        $res = [];
        foreach ($stmt as $fila) {
            $res[] = new static($fila);
        }

        return $res;
    }

    public static function por_id($id, ?PDO $pdo = null, $bloqueo = false): ?static
    {
        $pdo = $pdo ?? conectar();
        $tabla = static::$tabla;
        $sql = "SELECT * FROM $tabla WHERE id = :id";
        if ($bloqueo) {
            $sql .= ' FOR UPDATE';
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch();
        if ($fila !== false) {
            return new static($fila);
        }
        return null;
    }
}
