<?php

use Factories\MapperFactory;
use Drivers\Database\DatabaseConfig;

/**
 * Class Mapper
 */
class Mapper
{

    /** @var \Drivers\Database\DatabaseConfig */
    public $dbconfig;

    /**
     * @var mixed
     */
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

        $config = new DatabaseConfig;
        $config->setConfig($type, $host, $user, $password, $database, $port, $socket);
        $this->dbconfig = $config;

    }

    /**
     * @return array
     */
    public function getDbConfig()
    {
        return $this->dbconfig->getConfig();
    }

    /**
     * @param null $name
     *
     * @return MapperFactory
     */
    public function getMapperFactory($name = null)
    {

        return new MapperFactory($name, $this->dbconfig);

    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validateDbConnection()
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory();
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();

        if (! $mapper) {
            if ($mapperFactory->getError()) {
                throw new \Exception($mapperFactory->getError());
            } else {
                throw new \Exception("An unknown error occured while trying to test the database connection.");
            }
        }

        if (! $mapper->validateDbConnection()) {
            throw new \Exception("Could not validate the database connection.");
        }

        return true;

    }

    /**
     * @param $model
     *
     * @return bool
     * @throws Exception
     */
    public function validateModel($model)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($model);
        if (! $mapperFactory->isValidModel()) {
            if ($mapperFactory->getError()) {
                throw new \Exception($mapperFactory->getError());
            } else {
                throw new \Exception("An unknown error occured while trying to load the model.");
            }
        }

        return true;
    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws Exception
     */
    public function getFields($name)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($name);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();

        if (!$mapper) {
            if ($mapperFactory->getError()) {
                throw new \Exception($mapperFactory->getError());
            } else {
                throw new \Exception("An unknown error occured while trying to retrieve the fields.");
            }
        }

        $mapper->setDefaults();

        return $mapper->getTableProperties();

    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws Exception
     */
    public function getInfo($name)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($name);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();

        if (!$mapper) {
            if ($mapperFactory->getError()) {
                throw new \Exception($mapperFactory->getError());
            } else {
                throw new \Exception("An unknown error occured while trying to retrieve the model or database info.");
            }
        }

        $mapper->setDefaults();

        return $mapper->getModelTableInfo();

    }

}