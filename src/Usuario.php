<?php

class Usuario
{
    public $id;
    public $username;

    public function __construct($campos)
    {
        $this->id = $campos['id'];
        $this->username = $campos['username'];
    }
}
