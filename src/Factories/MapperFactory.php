<?php namespace Factories;

use Contracts\ModelLoaderInterface;
use Contracts\ValidatorInterface;
use Drivers\Database\DatabaseConfig;
use Validators\DatabaseValidator;
use Validators\ModelValidator;

/**
 * Class MapperFactory
 *
 * @package Factories
 */
class MapperFactory
{

    /**
     * @var string
     */
    protected $name;

    /** @var \Drivers\Database\DatabaseConfig $dbconfig */
    protected $dbconfig;

    /**
     * @var mixed
     */
    protected $model;

    /**
     * @var mixed
     */
    protected $connection;

    /**
     * @var string
     */
    protected $error = null;

    /** @var \Contracts\ValidatorInterface $modelValidator */
    protected $modelValidator = null;

    /** @var \Contracts\ValidatorInterface $modelValidator */
    protected $databaseValidator = null;

    /**
     * @param                $name
     * @param DatabaseConfig $dbconfig
     */
    public function __construct($name, DatabaseConfig $dbconfig = null)
    {

        $this->name = $name;
        $this->dbconfig = $dbconfig;
        $this->setModelValidator(new ModelValidator());
        $this->setDatabaseValidator(new DatabaseValidator());

    }

    /**
     * @param ValidatorInterface $validator
     */
    public function setModelValidator(ValidatorInterface $validator)
    {
        $this->modelValidator = $validator;
    }

    /**
     * @return ValidatorInterface
     */
    public function getModelValidator()
    {
        return $this->modelValidator;
    }

    /**
     * @param ValidatorInterface $validator
     */
    public function setDatabaseValidator(ValidatorInterface $validator)
    {
        $this->databaseValidator = $validator;
    }

    /**
     * @return ValidatorInterface
     */
    public function getDatabaseValidator()
    {
        return $this->databaseValidator;
    }

    /**
     * @return bool|mixed
     */
    public function build()
    {

        if ($this->isValidModel()) {

            return $this->model;

        } elseif ($this->isValidRepository()) {

            return $this->connection;

        }

        $this->error = "The mapper was not able to find a valid model or database to get fields from.";

        return false;

    }

    /**
     * @return mixed
     */
    public function isValidRepository()
    {

        $this->connection = $this->getDatabaseValidator()->validate($this->name, $this->dbconfig);

        if (!$this->connection) {

            $this->error = "The field mapper was unable to connect to the given database.";

        }

        return $this->connection;

    }

    /**
     * @return mixed
     */
    public function isValidModel()
    {

        $this->model = $this->getModelValidator()->validate($this->name);

        if (!$this->model) {

            $this->error = "The field mapper does not recognize the model framework.";

        }

        return $this->model;

    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

}