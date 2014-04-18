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
     * @param Model                 $model
     * @param Database Connection   $dbConnection
     *
     * if using $dbConnection, it expects an associative array with the database
     * credentials needed for the type of database connection -
     * default connection type is mysql
     *
     * $dbConnection example: [
     *      'hostname' => 'somename',
     *      'user' => 'someuser',
     *      'password' => 'password',
     *      'database' => 'db_name',
     *      'type' => 'mysql'
     * ]
     *
     * obviously if you use another type of database, you would have to
     * possibly have different set of parameters, but will need to set the
     * database type, and create the DatabaseHelper for it
     *
     * @access public
     */
    public function __construct($model, $dbConnection = null)
    {
        if (class_exists($model)) {

            $model = new $model;

            if ($model instanceof Eloquent) {

                $this->modelInfo = new LaravelHelper($model);

            } elseif ($dbConnection) {

                $this->connect($model, $dbConnection);

            }

        }

        $this->modelInfo = new LaravelHelper($model);
    }


    private function connect($model, $dbConnection)
    {
        if (isset($dbConnection['type'])) {

            if (class_exists('\DatabaseHelpers\\Databases\\'.$dbConnection['type'])) {

                $klass = '\DatabaseHelpers\\Databases\\'.$dbConnection['type'];
                $this->modelInfo = new $klass($model, $dbConnection);

            }

        }

    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return mixed
     */
    public static function getModelTableInfo(Model $model)
    {
        $helper = new LaravelHelper($model);
        return $helper->getPropertiesFromTable();
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