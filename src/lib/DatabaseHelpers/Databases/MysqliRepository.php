<?php namespace DatabaseHelpers\Databases;

use DatabaseHelpers\ConfigReader;

class MysqliRepository
{

    public $dbConnection = null;

    public function __construct($config)
    {
        $this->dbConnection = new \mysqli(
            ConfigReader::getHost($config),
            ConfigReader::getUser($config),
            ConfigReader::getPassword($config),
            ConfigReader::getDatabase($config),
            ConfigReader::getPort($config),
            ConfigReader::getSocket($config)
        );
    }

    public function getTableColumns($model)
    {

        if ($this->checkForTable($model)) {

            return $this->getColumns($model);

        } elseif (self::checkForTable(strtolower($model))) {

            return $this->getColumns(strtolower($model));

        }

        return false;

    }

    public function getColumns($model)
    {

        $result = $this->dbConnection->query("SHOW COLUMNS FROM '".$model."'");

        if ($result->num_rows > 0) {

            return $result;

        }

        return null;

    }

    public function checkForTable($model)
    {

        $result = $this->dbConnection->query("SHOW TABLES LIKE '".$model."'");

        if ($result->num_rows == 1) {

            return true;

        }

        return false;

    }

}