<?php namespace Helpers;

class ConfigHelper
{

    protected $type;

    protected $host = null;

    protected $user = null;

    protected $password = null;

    protected $database = null;

    protected $port = null;

    protected $socket = null;

    public function setConfig($type, $host, $user, $password, $database, $port, $socket)
    {

        $this->setType($type);
        $this->setHost($host);
        $this->setUser($user);
        $this->setPassword($password);
        $this->setDatabase($database);
        $this->setPort($port);
        $this->setSocket($socket);

    }

    public function setType($type)
    {

        if ($type) {

            $this->type = $type;

        } else {

            throw new \Exception("Config type parameter is not set.");

        }

    }

    public function getType()
    {

        return $this->type;

    }

    public function setHost($host)
    {

        if ($host) {

            $this->host = $host;

        } else {

            throw new \Exception("Config host parameter is not set.");

        }

    }

    public function getHost()
    {

        return $this->host;

    }

    public function setUser($user)
    {

        if ($user) {

            $this->user = $user;

        } else {

            throw new \Exception("Config user parameter is not set.");

        }

    }

    public function getUser()
    {

        return $this->user;

    }

    public function setPassword($password)
    {

        if ($password) {

            $this->password = $password;

        } else {

            throw new \Exception("Config password parameter is not set.");

        }

    }

    public function getPassword()
    {

        return $this->password;

    }

    public function setDatabase($database)
    {

        if ($database) {

            $this->database = $database;

        } else {

            throw new \Exception("Config database parameter is not set.");

        }

    }

    public function getDatabase()
    {

        return $this->database;

    }

    public function setPort($port)
    {

        $this->port = $port;

    }

    public function getPort()
    {

        return $this->port;

    }

    public function setSocket($socket)
    {

        $this->socket = $socket;

    }

    public function getSocket()
    {

        return $this->socket;

    }

}