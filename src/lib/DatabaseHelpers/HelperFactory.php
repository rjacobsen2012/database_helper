<?php namespace DatabaseHelpers;

use DatabaseHelpers\Databases\MysqliRepository;

class HelperFactory
{

    public static $allowed_databases = [
        'mysql'
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

                case "mysql":

                    return new MysqlHelper($model, new MysqliRepository($config));

                    break;

            }

        } else {

            throw new \Exception("Config type parameter [{$dbType}] is not valid.");

        }

    }

    public static function isSupportedSource($dbType)
    {

        if (in_array($dbType, self::$allowed_databases)) {

            return true;

        }

        return false;

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