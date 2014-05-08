<?php namespace Contracts;

use Drivers\Database\DatabaseConfig;

/**
 * Interface ValidatorInterface
 *
 * @package Contracts
 */
interface ValidatorInterface
{
    /**
     * @param                $model
     * @param DatabaseConfig $config
     *
     * @return mixed
     */
    public function validate($model, DatabaseConfig $config = null);
}