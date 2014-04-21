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
     * @param Model                 $model
     * @param Database type         $type
     *
     * This $type is the type of database you want to connect to. This
     * will use the /config/helperConfig database connection type, with
     * the database credentials to connect to the database and attempt
     * to get the table info.
     *
     * @access public
     */
    public function __construct($model, $type = null)
    {
        if (class_exists($model)) {

            $model = new $model;

            if ($model instanceof Illuminate\Database\Eloquent\Model) {

                $this->modelInfo = new LaravelHelper($model);

            } elseif ($type) {

                $this->modelInfo = $this->klassConnect($model, $type);

            }

        }

    }

    /**
     * @param Model                 $model
     * @param Database type         $type
     *
     * This $type is the type of database you want to connect to. This
     * will use the /config/helperConfig database connection type, with
     * the database credentials to connect to the database and attempt
     * to get the table info.
     *
     * @access private
     */
    private function getKlass($model, $type)
    {
        if (class_exists('\DatabaseHelpers\\Databases\\'.$type)) {

            return '\DatabaseHelpers\\Databases\\'.$type;

        }

        return null;

    }

    /**
     * @param Model                 $model
     * @param Database type         $type
     *
     * This $type is the type of database you want to connect to. This
     * will use the /config/helperConfig database connection type, with
     * the database credentials to connect to the database and attempt
     * to get the table info.
     *
     * @access private
     */
    private function klassConnect($model, $type)
    {

        $klass = $this->getKlass($model, $type);

        if (!is_null($klass)) {

            $this->modelInfo = new $klass($model, $type);

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