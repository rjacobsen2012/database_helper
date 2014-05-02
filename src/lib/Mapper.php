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

    public function getMapperFactory($name = null)
    {

        return new MapperFactory($name, $this->dbconfig);

    }

    public function testDbConnection()
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory();
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();
        return $mapper->testDbConnectionFails();

    }

    public function getFields($name)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($name);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();
        $mapper->setDefaults();
        return $mapper->getTableProperties();

    }

    public function getInfo($name)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($name);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();
        return $mapper->getModelTableInfo();

    }

}