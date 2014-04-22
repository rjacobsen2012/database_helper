<?php namespace DatabaseHelpers;

use DatabaseHelpers\Databases\MysqliRepository;
use Illuminate\Exception;

class HelperFactory
{

    public static $allowed_databases = [
        'mysqli'
    ];

    public static function make($model, $config)
    {

        if (self::isLaravel($model)) {

            return new \DatabaseHelpers\LaravelHelper($model);

        } elseif ($config) {

            return self::loadHelper($model, $config);

        }

    }

    public static function loadHelper($model, $config)
    {

        $dbType = ConfigReader::getType($config);

        if (self::isSupportedSource($dbType)) {

            switch ($dbType) {

                case "mysqli":

                    $dbConnection = MysqliRepository::connect($dbType, $config);
                    return new MysqlHelper($model, $dbConnection);

                    break;

            }

        }

    }

    public static function isSupportedSource($dbType)
    {

        if (!in_array($dbType, self::$allowed_databases)) {

            throw new ExceptionHandler("Config type parameter [{$dbType}] is not valid.");

        } else {

            return true;

        }

    }

    public static function isLaravel($model)
    {

        if (class_exists($model)) {

            $model = new $model;

            if ($model instanceof Illuminate\Database\Eloquent\Model) {

                return true;

            }

        }

        return false;

    }

}