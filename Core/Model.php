<?php
namespace Core;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }
}

