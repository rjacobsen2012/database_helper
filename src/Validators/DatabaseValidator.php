<?php namespace Validators;

use Contracts\ValidatorInterface;
use Drivers\Database\DatabaseService;
use Drivers\Database\Mysql\MysqlRepository;
use Helpers\ConfigHelper;
use Helpers\DatabaseHelper;
use Helpers\MysqlHelper;

class DatabaseValidator implements ValidatorInterface
{

    protected $model = null;

    protected $repository = null;

    protected $repositories = [
        'mysql'
    ];

    protected $connection = null;

    /** @var \Helpers\ConfigHelper */
    protected $config = null;

    public function validate($model, ConfigHelper $config = null)
    {
        $this->model = $model;
        $this->config = $config;
        $this->setRepository();
        return $this->checkRepositories();
    }

    public function checkRepositories()
    {

        foreach ($this->repositories as $repository) {

            if ($this->checkRepository($repository)) {

                if ($this->connection) {

                    return $this->connection;

                }

            }

        }

        return false;

    }

    public function checkRepository($repository)
    {

        switch ($repository) {

            case 'mysql':

                $this->connection = $this->isMysql();

                return $this->connection;

                break;

            default:

                return false;

        }

    }

    public function isMysql()
    {

        if ($this->config->getType() == 'mysql') {

            return new DatabaseService(
                $this->model,
                new DatabaseHelper(),
                new MysqlRepository(
                    new \mysqli(),
                    $this->config,
                    new MysqlHelper()
                )
            );

        }

        return false;

    }

    public function setRepository()
    {

        if (!is_null($this->config)) {

            $this->repository = $this->config->getType();

        }

    }

    public function getRepository()
    {

        return $this->repository;

    }

}