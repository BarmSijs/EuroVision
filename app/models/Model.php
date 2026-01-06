<?php
require_once __DIR__ . '/../Db.php';

class Model
{
    protected ?PDO $db = null;

    public function __construct()
    {
        $this->db = (new Db())->connect();
    }
}