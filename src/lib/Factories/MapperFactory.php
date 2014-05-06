<?php namespace Factories;

use Contracts\ModelLoaderInterface;
use Helpers\ConfigHelper;
use Helpers\LaravelHelper;
use Helpers\MysqlHelper;
use Helpers\DatabaseHelper;
use Loaders\ModelLoader;
use Drivers\Database\Mysql\MysqlRepository;
use Drivers\Laravel\LaravelService;
use Drivers\Database\DatabaseService;
use Illuminate\Database\Eloquent\Model;
use mysqli;

class MapperFactory
{

    public $name;

    public $repository = null;

    /** @var \Helpers\ConfigHelper $dbconfig */
    public $dbconfig;

    public $pluralName;

    public $model;

    public $repositoryConnection;

    protected $error = null;

    /** @var \Contracts\ModelLoaderInterface null */
    protected $modelLoader = null;

    public $repositories = [
        'mysql'
    ];

    public $frameworks = [
        'laravel'
    ];

    public function __construct($name, ConfigHelper $dbconfig = null)
    {

        $this->name = $name;
        $this->dbconfig = $dbconfig;
        $this->setModelLoader(new ModelLoader());

    }

    public function setModelLoader(ModelLoaderInterface $modelLoader)
    {
        $this->modelLoader = $modelLoader;
    }

    public function getModelLoader()
    {
        return $this->modelLoader;
    }

    public function setRepository()
    {

        if (!is_null($this->dbconfig)) {

            $this->repository = $this->dbconfig->getType();

        }

    }

    public function getRepository()
    {

        return $this->repository;

    }

    public function build()
    {

        $framework = $this->checkFrameworks();

        if ($framework) {

            switch ($framework) {

                case "laravel":

                    return new LaravelService(
                        $this->model,
                        new LaravelHelper()
                    );

                    break;

            }

        }

        $this->setRepository();

        if ($this->isValidRepository()) {

            return $this->getDatabaseService();

        }

        $this->error = "The mapper was not able to find a valid model or database to get fields from.";

        return false;

    }

    public function getDatabaseService()
    {

        switch ($this->getRepository()) {

            case 'mysql':

                return new DatabaseService(
                    $this->name,
                    new DatabaseHelper(),
                    new MysqlRepository(new mysqli, $this->dbconfig, new MysqlHelper())
                );

                break;

            default:

                return false;

        }

    }

    public function isValidRepository()
    {

        if ($this->getRepository() && in_array($this->getRepository(), $this->repositories)) {

            return true;

        }

        return false;

    }

    public function isLaravel()
    {

        if ($this->name) {

            $loadedModel = $this->getModelLoader()->loadModel($this->name);

            if ($loadedModel && $loadedModel instanceof Model) {

                $this->model = $loadedModel;
                return true;

            }

        }

        $this->error = "The field mapper was not able to load the model.";
        return false;

    }

    public function isValidModel()
    {
        return $this->checkFrameworks();
    }

    public function checkFrameworks()
    {
        foreach ($this->frameworks as $framework) {

            if ($this->checkFramework($framework)) {

                return $framework;

            }

        }

        $this->error = "The field mapper does not recognize the model framework.";
        return false;
    }

    public function checkFramework($framework)
    {
        switch ($framework) {

            case "laravel":

                return $this->isLaravel();

                break;

            default:

                $this->error = "The field mapper does not recognize the model framework.";
                return false;

        }
    }

    public function getError()
    {
        return $this->error;
    }

}