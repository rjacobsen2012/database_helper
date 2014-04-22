<?php namespace DatabaseHelpers\Databases;

class MysqliRepository
{

    public static function getTableColumns($model, $dbConnection)
    {

        if (self::checkForTable($model, $dbConnection)) {

            $result = $dbConnection->query("SHOW COLUMNS FROM `".$model."`");

            if ($result->num_rows > 0) {

                return $result;

            }

        }

        return false;

    }

    public static function checkForTable($model, $dbConnection)
    {

        $result = $dbConnection->query("SHOW TABLES LIKE `".$model."`");

        if ($result->num_rows == 1) {

            return true;

        }

        return false;

    }

}