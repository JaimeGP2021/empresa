<?php

require 'Modelo.php';

namespace App\Tablas;

use DateTime;
use DateTimeZone;
use PDO;

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

    public static function comprobar_codigo($codigo, &$errores, ?PDO $pdo = null, $id = null)
    {
        $pdo = $pdo ?? conectar();
        if ($codigo == '') {
            anyadir_error('codigo', 'El código no puede estar vacío', $errores);
        } elseif (mb_strlen($codigo) > 2) {
            anyadir_error('codigo', 'El código es demasiado largo', $errores);
        } else {
            $departamento = static::por_codigo($codigo, $pdo);
            if ($departamento !== null &&
                ($id === null || $departamento->id != $id)) {
                anyadir_error('codigo', 'Ese departamento ya existe', $errores);
            }
        }
    }


    public static function comprobar_departamento_id(&$departamento_id, &$errores, ?PDO $pdo = null)
    {
        $pdo = $pdo ?? conectar();
        if ($departamento_id == '') {
            $departamento_id = null;
        } elseif (!ctype_digit($departamento_id)) {
            anyadir_error('departamento_id', 'El departamento no es válido', $errores);
        } elseif (static::por_id($departamento_id, $pdo) === false) {
            anyadir_error('departamento_id', 'El departamento no existe', $errores);
        }
    }

    public static function comprobar_denominacion($denominacion, &$errores)
    {
        if ($denominacion == '') {
            anyadir_error('denominacion', 'La denominación no puede estar vacía', $errores);
        } elseif (mb_strlen($denominacion) > 255) {
            anyadir_error('denominacion', 'La denominación es demasiado larga', $errores);
        }
    }

    public static function comprobar_localidad(&$localidad, &$errores)
    {
        if ($localidad == '') {
            $localidad = null;
        } elseif (mb_strlen($localidad) > 255) {
            anyadir_error('localidad', 'La localidad es demasiado larga', $errores);
        }
    }

    public static function comprobar_fecha_alta(&$fecha_alta, &$errores)
    {
        $matches = [];
        if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})((T| )([0-9]{2}):([0-9]{2})(:([0-9]{2}))?)?$/', $fecha_alta, $matches) === 0) {
            anyadir_error('fecha_alta', 'La fecha tiene un formato incorrecto', $errores);
        } else {
            [$anyo, $mes, $dia] = [$matches[1], $matches[2], $matches[3]];
            if (!checkdate($mes, $dia, $anyo)) {
                anyadir_error('fecha_alta', 'La fecha es incorrecta', $errores);
            } else {
                if (count($matches) > 4) {
                    [$horas, $minutos] = [$matches[6], $matches[7]];
                    $segundos = '00';
                    if ($horas > 23 || $minutos > 59) {
                        anyadir_error('fecha_alta', 'La hora es incorrecta', $errores);
                    } elseif (count($matches) > 9) {
                        $segundos = $matches[9];
                        if ($segundos > 59) {
                            anyadir_error('fecha_alta', 'La hora es incorrecta', $errores);
                        }
                    }
                }
            }
        }

        if (!isset($errores['fecha_alta'])) {
            $fecha_alta = "$anyo-$mes-$dia $horas:$minutos:$segundos";
            $dt = new DateTime($fecha_alta, new DateTimeZone('Europe/Madrid'));
            $dt->setTimezone(new DateTimeZone('UTC'));
            $fecha_alta = $dt->format('Y-m-d H:i:s');
        }
    }

    public static function comprobar_id($id, ?PDO $pdo = null): array|false
    {
        $pdo = $pdo ?? conectar();
        if (!isset($_GET['id'])) {
            return false;
        }
        $id = trim($_GET['id']);
        if (!ctype_digit($id)) {
            return false;
        }
        $stmt = $pdo->prepare('SELECT *
                                FROM departamentos
                                WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
