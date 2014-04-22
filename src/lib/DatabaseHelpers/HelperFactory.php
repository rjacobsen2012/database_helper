<?php namespace DatabaseHelpers;

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

        } elseif($config) {

            try {

                $dbType = self::getDatabaseType($config);

                $dbConnection = new $dbType(
                    self::getHost($config),
                    self::getUsername($config),
                    self::getPassword($config),
                    self::getDatabase($config),
                    self::getPort($config),
                    self::getSocket($config)
                );

            } catch (Exception $e) {

                echo 'Caught exception: ', $e->getMessage(), "\n";

            }

            switch ($dbType) {

                case "mysql":

                    return new \DatabaseHelpers\MysqlHelper($model, $dbConnection);

                    break;

            }

        }

    }

    public static function checkIfValid($dbType)
    {

        if (!in_array($dbType, self::$allowed_databases)) {

            throw new Exception("[{$dbType}] is not a valid database option.");

        }

        return true;

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

    public static function isMysqli($type)
    {

        if ($type == "mysqli") {

            return true;

        }

        return false;

    }

    public static function getDatabaseType($config)
    {

        return self::getType($config);

    }

    public static function getType($config)
    {

        if (isset($config->type) && self::checkIfValid($config->type)) {

            return $config->type;

        }

        return null;

    }

    public static function getHost($config)
    {

        if (isset($config->host)) {

            return $config->host;

        }

        return null;

    }

    public static function getUsername($config)
    {

        if (isset($config->user)) {

            return $config->user;

        }

        return null;

    }

    public static function getPassword($config)
    {

        if (isset($config->password)) {

            return $config->password;

        }

        return null;

    }

    public static function getDatabase($config)
    {

        if (isset($config->database)) {

            return $config->database;

        }

        return null;

    }

    public static function getPort($config)
    {

        if (isset($config->port)) {

            return $config->port;

        }

        return null;

    }

    public static function getSocket($config)
    {

        if (isset($config->socket)) {

            return $config->socket;

        }

        return null;

    }

}