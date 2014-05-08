<?php namespace Validators;

use Contracts\ValidatorInterface;
use Drivers\Database\DatabaseService;
use Drivers\Database\Mysql\MysqlRepository;
use Drivers\Database\DatabaseConfig;
use Helpers\ServiceHelper;

/**
 * Class DatabaseValidator
 *
 * @package Validators
 */
class DatabaseValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $validRepositories = [
        'mysql'
    ];

    /**
     * @param                $model
     * @param DatabaseConfig $config
     *
     * @return mixed
     */
    public function validate($model, DatabaseConfig $config = null)
    {
        if ($this->isValidRepository($config->getType())) {

            switch ($config->getType()) {

                case "mysql":

                    return $this->getMysql($model, $config);

                    break;

            }

        }

        return null;

    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function isValidRepository($type)
    {

        return in_array($type, $this->validRepositories);

    }

    /**
     * @param $model
     * @param $config
     *
     * @return DatabaseService
     */
    public function getMysql($model, $config)
    {

        return new DatabaseService(
            $model,
            new ServiceHelper(),
            new MysqlRepository(
                new \mysqli(),
                $config,
                new ServiceHelper()
            )
        );

    }

}