<?php namespace Drivers\Database;

/**
 * Class DatabaseConfig
 *
 * @package Drivers\Database
 */
class DatabaseConfig
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $host = null;

    /**
     * @var string
     */
    protected $user = null;

    /**
     * @var string
     */
    protected $password = null;

    /**
     * @var string
     */
    protected $database = null;

    /**
     * @var string
     */
    protected $port = null;

    /**
     * @var string
     */
    protected $socket = null;

    /**
     * @param string $type
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $port
     * @param string $socket
     */
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

    /**
     * @return array
     */
    public function getConfig()
    {

        return [
            'type'      => $this->getType(),
            'host'      => $this->getHost(),
            'user'      => $this->getUser(),
            'password'  => $this->getPassword(),
            'database'  => $this->getDatabase(),
            'port'      => $this->getPort(),
            'socket'    => $this->getSocket()
        ];

    }

    /**
     * @param $type
     *
     * @throws \Exception
     */
    public function setType($type)
    {

        if ($type) {

            $this->type = $type;

        } else {

            throw new \Exception("Config type parameter is not set.");

        }

    }

    /**
     * @return string
     */
    public function getType()
    {

        return $this->type;

    }

    /**
     * @param $host
     *
     * @throws \Exception
     */
    public function setHost($host)
    {

        if ($host) {

            $this->host = $host;

        } else {

            throw new \Exception("Config host parameter is not set.");

        }

    }

    /**
     * @return string
     */
    public function getHost()
    {

        return $this->host;

    }

    /**
     * @param $user
     *
     * @throws \Exception
     */
    public function setUser($user)
    {

        if ($user) {

            $this->user = $user;

        } else {

            throw new \Exception("Config user parameter is not set.");

        }

    }

    /**
     * @return string
     */
    public function getUser()
    {

        return $this->user;

    }

    /**
     * @param $password
     *
     * @throws \Exception
     */
    public function setPassword($password)
    {

        if ($password) {

            $this->password = $password;

        } else {

            throw new \Exception("Config password parameter is not set.");

        }

    }

    /**
     * @return string
     */
    public function getPassword()
    {

        return $this->password;

    }

    /**
     * @param $database
     *
     * @throws \Exception
     */
    public function setDatabase($database)
    {

        if ($database) {

            $this->database = $database;

        } else {

            throw new \Exception("Config database parameter is not set.");

        }

    }

    /**
     * @return string
     */
    public function getDatabase()
    {

        return $this->database;

    }

    /**
     * @param $port
     */
    public function setPort($port)
    {

        $this->port = $port;

    }

    /**
     * @return string
     */
    public function getPort()
    {

        return $this->port;

    }

    /**
     * @param $socket
     */
    public function setSocket($socket)
    {

        $this->socket = $socket;

    }

    /**
     * @return string
     */
    public function getSocket()
    {

        return $this->socket;

    }

}