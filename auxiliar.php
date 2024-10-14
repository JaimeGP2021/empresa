<?php
function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=datos', 'datos', 'datos');
}

function obtener_get($par)
{
    return isset($_GET[$par]) ? trim($_GET[$par]) : null;
}

function selected($criterio, $valor) 
{
    return $criterio == $valor ? 'selected' : '';
}
