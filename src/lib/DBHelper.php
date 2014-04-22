<?php

use DatabaseHelpers\HelperFactory;

class DBHelper
{

    /**
     * @var $modelInfo
     * @static
     */
    protected $modelInfo;

    /**
     * @var $config
     * @static
     */
    protected $config;

    /**
     * @param Model                  $model
     * @param Database configuration $config
     *
     * This $config expects an object with your database
     * type, host, user, password, database
     *
     * @access public
     */
    public function __construct($model, $config = null)
    {

        $this->modelInfo = HelperFactory::make($model, $config);

    }

    /**
     * @return mixed
     */
    public function getModelInfo()
    {
        return $this->modelInfo->getModelTableInfo();
    }

    /**
     * @return mixed
     */
    public function getModelTableProperties()
    {
        return $this->modelInfo->getTableProperties();
    }

    /**
     * @return mixed
     */
    public function getModelTableMethods()
    {
        return $this->modelInfo->getTableMethods();
    }

}