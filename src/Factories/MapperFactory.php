<?php namespace Factories;

use Contracts\ModelLoaderInterface;
use Contracts\ValidatorInterface;
use Helpers\ConfigHelper;
use Validators\DatabaseValidator;
use Validators\ModelValidator;

class MapperFactory
{

    protected $name;

    /** @var \Helpers\ConfigHelper $dbconfig */
    protected $dbconfig;

    protected $model;

    protected $connection;

    protected $error = null;

    /** @var \Contracts\ValidatorInterface $modelValidator */
    protected $modelValidator = null;

    /** @var \Contracts\ValidatorInterface $modelValidator */
    protected $databaseValidator = null;

    public function __construct($name, ConfigHelper $dbconfig = null)
    {

        $this->name = $name;
        $this->dbconfig = $dbconfig;
        $this->setModelValidator(new ModelValidator());
        $this->setDatabaseValidator(new DatabaseValidator());

    }

    public function setModelValidator(ValidatorInterface $validator)
    {
        $this->modelValidator = $validator;
    }

    public function getModelValidator()
    {
        return $this->modelValidator;
    }

    public function setDatabaseValidator(ValidatorInterface $validator)
    {
        $this->databaseValidator = $validator;
    }

    public function getDatabaseValidator()
    {
        return $this->databaseValidator;
    }

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

    public function isValidRepository()
    {

        $this->connection = $this->getDatabaseValidator()->validate($this->name, $this->dbconfig);

        if (!$this->connection) {

            $this->error = "The field mapper was unable to connect to the given database.";

        }

        return $this->connection;

    }

    public function isValidModel()
    {

        $this->model = $this->getModelValidator()->validate($this->name);

        if (!$this->model) {

            $this->error = "The field mapper does not recognize the model framework.";

        }

        return $this->model;

    }

    public function getError()
    {
        return $this->error;
    }

}