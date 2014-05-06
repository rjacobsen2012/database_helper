<?php

use Factories\MapperFactory;
use Helpers\ConfigHelper;
use Handlers\ResponseHandler;

class Mapper
{

    public $dbconfig;

    public $mapper;

    /** @var \Handlers\ResponseHandler null */
    protected $responseHandler = null;

    public function __construct()
    {
        $this->setResponseHandler(new ResponseHandler());
    }

    public function setResponseHandler(ResponseHandler $responseHandler)
    {
        $this->responseHandler = $responseHandler;
    }

    public function getResponseHandler()
    {
        return $this->responseHandler;
    }

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

        if (!$mapper) {
            if ($mapperFactory->getError()) {
                $this->responseHandler->setError($mapperFactory->getError());
            } else {
                $this->responseHandler->setError(
                    "An unknown error occured while trying to test the database connection."
                );
            }
        } else {
            $this->responseHandler->setSuccess(true);

            $this->responseHandler->setResult($mapper->testDbConnectionFails());
        }


        return $this->responseHandler;

    }

    public function testModel($model)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($model);
        if (! $mapperFactory->isValidModel()) {
            $this->responseHandler->setSuccess(false);

            if ($mapperFactory->getError()) {
                $this->responseHandler->setError($mapperFactory->getError());
            } else {
                $this->responseHandler->setError(
                    "An unknown error occured while trying to load the model."
                );
            }
        } else {
            $this->responseHandler->setSuccess(true);
        }

        return $this->responseHandler;
    }

    public function getFields($name)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($name);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();

        if (!$mapper) {
            if ($mapperFactory->getError()) {
                $this->responseHandler->setError($mapperFactory->getError());
            } else {
                $this->responseHandler->setError(
                    "An unknown error occured while trying to retrieve the fields."
                );
            }
        } else {
            $this->responseHandler->setSuccess(true);

            $mapper->setDefaults();
            $this->responseHandler->setResult($mapper->getTableProperties());
        }


        return $this->responseHandler;

    }

    public function getInfo($name)
    {

        /** @var \Factories\MapperFactory $mapperFactory */
        $mapperFactory = $this->getMapperFactory($name);
        /** @var \Contracts\ServicesInterface $mapper */
        $mapper = $mapperFactory->build();

        if (!$mapper) {
            if ($mapperFactory->getError()) {
                $this->responseHandler->setError($mapperFactory->getError());
            } else {
                $this->responseHandler->setError(
                    "An unknown error occured while trying to retrieve the model or database info."
                );
            }
        } else {
            $this->responseHandler->setSuccess(true);

            $mapper->setDefaults();
            $this->responseHandler->setResult($mapper->getModelTableInfo());
        }


        return $this->responseHandler;

    }

}