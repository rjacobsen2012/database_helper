<?php namespace Factories;

use Helpers\ConfigHelper;
use Drivers\Laravel\LaravelHelper;
use Drivers\Database\Mysql\MysqlHelper;
use Loaders\ModelLoader;
use Drivers\Database\Mysql\MysqlRepository;
use Drivers\Laravel\LaravelService;
use Drivers\Database\DatabaseService;
use Illuminate\Database\Eloquent\Model;
use mysqli;

class MapperFactory
{

    public $name;

    public $repository;

    /** @var \Helpers\ConfigHelper $dbconfig */
    public $dbconfig;

    public $pluralName;

    public $model;

    public $repositoryConnection;

    public $repositories = [
        'mysql'
    ];

    public function __construct($name, ConfigHelper $dbconfig = null)
    {

        $this->name = $name;
        $this->dbconfig = $dbconfig;

    }

    public function setRepository()
    {

        if (!is_null($this->dbconfig)) {

            $this->repository = $this->dbconfig->getType();

        }

    }

    public function build()
    {

        $this->setRepository();

        if ($this->isLaravel()) {

            return new LaravelService(
                $this->model,
                new LaravelHelper()
            );

        } else {

            if ($this->isValidRepository()) {

                return $this->getDatabaseService();

            }

        }

    }

    public function getDatabaseService()
    {

        switch ($this->repository) {

            case 'mysql':

                return new DatabaseService(
                    $this->name,
                    new MysqlRepository(new mysqli, $this->dbconfig, new MysqlHelper()),
                    new MysqlHelper()
                );

                break;

            default:

                return false;

        }

    }

    public function isValidRepository()
    {

        if ($this->repository && in_array($this->repository, $this->repositories)) {

            return true;

        }

        return false;

    }

    public function isLaravel()
    {

        $model = new ModelLoader();
        $loadedModel = $model->loadModel($this->name);

        if ($loadedModel && $loadedModel instanceof Model) {

            $this->model = $loadedModel;
            return true;

        }

        return false;

    }

}