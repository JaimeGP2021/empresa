<?php

require 'Modelo.php';

namespace App\Tablas;

use PDO;

class Usuario extends Modelo
{
    protected static string $tabla = 'usuarios';
    protected static string $orden_defecto = 'username';

    public $id;
    public $username;
    public $password;

    public function __construct($campos)
    {
        $this->id = $campos['id'];
        $this->username = $campos['username'];
        $this->password = $campos['password'];
    }

    public function comprobar_password($password)
    {
        return password_verify($password, $this->password);
    }

    public static function esta_logueado()
    {
        return isset($_SESSION['login']);
    }

    public static function logueado(): ?static
    {
        return static::esta_logueado() ? unserialize($_SESSION['login']) : null;
    }

    public static function logueado_es_admin(): bool
    {
        $logueado = static::logueado();
        if ($logueado !== null) {
            return $logueado->username == 'admin';
        }
        return false;
    }

    public static function por_username($username, ?PDO $pdo = null): ?static
    {
        $pdo = $pdo ?? conectar();
        $stmt = $pdo->prepare('SELECT *
                                FROM usuarios
                                WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $fila = $stmt->fetch();
        return $fila ? new static($fila) : null;
    }
}
