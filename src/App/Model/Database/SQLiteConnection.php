<?php

namespace App\Model\Database;

class SQLiteConnection
{
    private $pdo;
    private static $path;

    public function __construct()
    {
        self::$path = realpath(dirname(__FILE__)) . '/../../../../data/sqlite.db';
    }

    public function connect()
    {

        if ($this->pdo == null) {
            $this->pdo = new \PDO('sqlite:' . self::$path);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    }

}