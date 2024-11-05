<?php

class Usuario
{
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

    public static function todos(
        array $where = [],
        array $execute = [],
        ?PDO $pdo = null,
        string $criterio = 'AND',
        ?string $orden = null,
    ): array {
        $pdo = $pdo ?? conectar();
        $where = !empty($where) ? 'WHERE ' . implode(" $criterio ", $where) : '';
        $orden = $orden ?? 'username';
        $execute[':orden'] = $orden;

        $stmt = $pdo->prepare("SELECT *
                                 FROM usuarios
                               $where
                             ORDER BY :orden");
        $stmt->execute($execute);
        $res = [];
        foreach ($stmt->fetchAll() as $fila) {
            $res[] = new static($fila);
        }

        return $res;
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
