<?php namespace Contracts;

use Helpers\ConfigHelper;

interface ValidatorInterface
{
    public function validate($model, ConfigHelper $config = null);
}