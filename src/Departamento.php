<?php

require 'Modelo.php';

class Departamento extends Modelo
{
    protected static string $tabla = 'departamentos';
    protected static string $orden_defecto = 'denominacion';

    public $id;
    public $codigo;
    public $denominacion;
    public $localidad;
    public $fecha_alta;

    private function _valor($arr, $campo)
    {
        return isset($arr[$campo]) ? $arr[$campo] : null;
    }

    public function __construct(array $campos)
    {
        $this->id = $this->_valor($campos, 'id');
        $this->codigo = $this->_valor($campos, 'codigo');
        $this->denominacion = $this->_valor($campos, 'denominacion');
        $this->localidad = $this->_valor($campos, 'localidad');
        $this->fecha_alta = $this->_valor($campos, 'fecha_alta');
    }

    public static function por_codigo($codigo, ?PDO $pdo = null, $bloqueo = false): ?static
    {
        $pdo = $pdo ?? conectar();
        $sql = 'SELECT * FROM departamentos WHERE codigo = :codigo';
        if ($bloqueo) {
            $sql .= ' FOR UPDATE';
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':codigo' => $codigo]);
        $fila = $stmt->fetch();
        if ($fila !== false) {
            return new static($fila);
        }
        return null;
    }

    public function borrar(?PDO $pdo = null): bool
    {
        $pdo = $pdo ?? conectar();
        $stmt = $pdo->prepare('DELETE FROM departamentos
                                WHERE id = :id');
        $stmt->execute([':id' => $this->id]);
        return $stmt->rowCount() === 1;
    }

    public function insertar(?PDO $pdo = null)
    {
        $pdo = $pdo ?? conectar();
        $stmt = $pdo->prepare('INSERT INTO departamentos (
                                    codigo,
                                    denominacion,
                                    localidad,
                                    fecha_alta
                                ) VALUES (
                                    :codigo,
                                    :denominacion,
                                    :localidad,
                                    :fecha_alta
                                )');
        $stmt->execute([
            ':codigo' => $this->codigo,
            ':denominacion' => $this->denominacion,
            ':localidad' => $this->localidad,
            ':fecha_alta' => $this->fecha_alta,
        ]);
    }

    public function cantidad_empleados(?PDO $pdo = null): int
    {
        $pdo = $pdo ?? conectar();
        $stmt = $pdo->prepare('SELECT COUNT(*)
                                 FROM empleados
                                WHERE departamento_id = :id');
        $stmt->execute([':id' => $this->id]);
        return $stmt->fetchColumn();
    }
}
