<?php
namespace App\Model\Database;


abstract class DbBasis
{
    private $dbqObject = null;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function getDbqObject()
    {
        if ($this->dbqObject == null) {
            $this->dbqObject = new DbQuery($this->config);
        }
        return $this->dbqObject;
    }

}