<?php

use Factories\MapperFactory;
use Helpers\ConfigHelper;

class Mapper
{

    public $dbconfig;

    public $mapper;

    /**
     * @param      $type
     * @param      $host
     * @param      $user
     * @param      $password
     * @param      $database
     * @param null $port
     * @param null $socket
     */
    public function setDbConfig($type, $host, $user, $password, $database, $port = null, $socket = null)
    {

        $config = new ConfigHelper;
        $config->setConfig($type, $host, $user, $password, $database, $port, $socket);
        $this->dbconfig = $config;

    }

    public function getDbConfig()
    {
        return $this->dbconfig->getConfig();
    }

    public function getFields($name)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = new MapperFactory($name, $this->dbconfig);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();
        return $mapper->getTableProperties();

    }

    public function getInfo($name)
    {

        $mapperFactory = new MapperFactory($name, $this->dbconfig);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();
        return $mapper->getModelTableInfo();

    }

}