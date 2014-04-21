<?php

use DatabaseHelpers\LaravelHelper;

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
        if (class_exists($model)) {

            $model = new $model;

            if ($model instanceof Illuminate\Database\Eloquent\Model) {

                $this->modelInfo = new LaravelHelper($model);

            } elseif ($config) {

                $this->config = $config;

                $this->modelInfo = $this->klassConnect($model);

            }

        }

    }

    /**
     * @access private
     */
    private function getKlass()
    {
        if (class_exists('\DatabaseHelpers\\Databases\\'.$this->config->type)) {

            return '\DatabaseHelpers\\Databases\\'.$this->config->type;

        }

        return null;

    }

    /**
     * @param Model                 $model
     *
     * This $type is the type of database you want to connect to. This
     * will use the /config/helperConfig database connection type, with
     * the database credentials to connect to the database and attempt
     * to get the table info.
     *
     * @access private
     */
    private function klassConnect($model)
    {

        $klass = $this->getKlass($model);

        if (!is_null($klass)) {

            $this->modelInfo = new $klass($model, $this->config);

            if ($this->modelInfo->getErrors()) {

                echo "There was a problem connecting to the database. \n\r".
                    print_r($this->modelInfo->getErrors(), true);
                die();

            }

        } else {

            echo "There was no database connection type for the type you requested.";
            die();

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