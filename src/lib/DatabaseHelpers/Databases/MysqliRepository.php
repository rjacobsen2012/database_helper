<?php namespace DatabaseHelpers\Databases;

use DatabaseHelpers\ConfigReader;

class MysqliRepository
{

    public static function connect($dbType, $config)
    {

        return new $dbType(
            ConfigReader::getHost($config),
            ConfigReader::getUser($config),
            ConfigReader::getPassword($config),
            ConfigReader::getDatabase($config),
            ConfigReader::getPort($config),
            ConfigReader::getSocket($config)
        );

    }

    public static function getTableColumns($model, $dbConnection)
    {

        if (self::checkForTable($model, $dbConnection)) {

            $result = $dbConnection->query("SHOW COLUMNS FROM '".$model."'");

            if ($result->num_rows > 0) {

                return $result;

            }

        } elseif (self::checkForTable(strtolower($model), $dbConnection)) {

            $result = $dbConnection->query("SHOW COLUMNS FROM '".$model."'");

            if ($result->num_rows > 0) {

                return $result;

            }

        }

        return false;

    }

    public static function checkForTable($model, $dbConnection)
    {

        $result = $dbConnection->query("SHOW TABLES LIKE '".$model."'");

        if ($result->num_rows == 1) {

            return true;

        }

        return false;

    }

}