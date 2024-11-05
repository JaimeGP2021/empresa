<?php

class Modelo
{
    protected static string $tabla;
    protected static string $orden_defecto;

    public function todos(
        array $where = [],
        array $execute = [],
        ?PDO $pdo = null,
        string $criterio = 'AND',
        ?string $orden = null,
    ): array
    {

    }
}
