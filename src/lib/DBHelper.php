<?php

use Illuminate\Database\Eloquent\Model;
use DatabaseHelpers\LaravelHelper;

class DBHelper
{

    /**
     * @var $modelInfo
     * @static
     */
    protected $modelInfo;

    /**
     * @param Model         $model
     * @param LaravelHelper $helper
     *
     * @access public
     */
    public function __construct(Model $model)
    {
        $this->modelInfo = new LaravelHelper($model);
    }


    public static function getModelTableInfo(Model $model)
    {
        $helper = new LaravelHelper($model);
        return $helper->getPropertiesFromTable();
    }


    public function getModelInfo()
    {
        return $this->modelInfo->getModelTableInfo();
    }


    public function getModelTableProperties()
    {
        return $this->modelInfo->getTableProperties();
    }


    public function getModelTableMethods()
    {
        return $this->modelInfo->getTableMethods();
    }

}