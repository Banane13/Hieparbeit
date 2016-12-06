<?php

namespace App\Model\Database;

class DbQuery
{
   /* @var $dbConnection \PDO */
    protected $dbConnection = null;

    /* @var $sqlStatement \PDOStatement */
    private $sqlStatement;

    public function __construct($config)
    {
        if ($this->dbConnection == null) {
            $this->dbConnection = $config['dbConnection'];
        }
    }

    public function query($query, $data = [])
    {
        $result = false;
        $this->sqlStatement = null;

        try {
            $this->sqlStatement = $this->dbConnection->prepare($query);
            if (count($data) > 0) {

                foreach ($data as $key => $value) {
                    $this->sqlStatement->bindValue($key, $value);
                }
            }
            $result = $this->sqlStatement->execute();
        } catch (\Exception $exception) {
            echo $exception->getMessage() . " \n";
        }
        return $result;
    }


    public function nextRow()
    {
        return $this->sqlStatement->fetch(\PDO::FETCH_ASSOC);
    }
}