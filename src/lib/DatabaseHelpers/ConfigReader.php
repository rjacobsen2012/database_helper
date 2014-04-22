<?php namespace DatabaseHelpers;

use Illuminate\Exception;

class ConfigReader
{

    public static function getType($config)
    {

        if (isset($config->type)) {

            return $config->type;

        } else {

            throw new ExceptionHandler("Config type parameter is not set.");

        }

    }

    public static function getHost($config)
    {

        if (isset($config->host)) {

            return $config->host;

        } else {

            throw new ExceptionHandler("Config host parameter is not set.");

        }

    }

    public static function getUser($config)
    {

        if (isset($config->user)) {

            return $config->user;

        } else {

            throw new ExceptionHandler("Config user parameter is not set.");

        }

    }

    public static function getPassword($config)
    {

        if (isset($config->password)) {

            return $config->password;

        } else {

            throw new ExceptionHandler("Config password parameter is not set.");

        }

    }

    public static function getDatabase($config)
    {

        if (isset($config->database)) {

            return $config->database;

        } else {

            throw new ExceptionHandler("Config database parameter is not set.");

        }

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