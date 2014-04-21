<?php namespace DatabaseHelpers\Databases;

use DB\DBInterface;
use Illuminate\Support\Str;

/**
 * Class DatabaseHelper
 *
 * @package DatabaseHelpers
 */
class MySql implements DBInterface
{

    /**
     * @access protected
     */
    protected $model;

    /**
     * @access protected
     */
    protected $table;

    /**
     * @access protected
     */
    protected $config;

    /**
     * @access protected
     */
    protected $schema;

    /**
     * @access protected
     */
    protected $errors = null;

    /**
     * @access protected
     */
    protected $dbConnection;

    /**
     * @access protected
     */
    protected $properties = [];

    /**
     * @access protected
     */
    protected $methods = [];

    /**
     * @param Model                 $model
     *
     * @access public
     */
    public function __construct($model, $config)
    {
        $this->model = $model;
        $this->config = $config;

        $this->dbConnect();

        if (!$this->getErrors()) {

            $this->getTableColumns();

        }

    }

    /**
     * @access private
     *
     * @return mixed
     */
    private function dbConnect()
    {

        if ($this->config) {

            $this->dbConnection = mysqli_connect(
                $this->config->host,
                $this->config->user,
                $this->config->password,
                $this->config->database
            );

            if (mysqli_connect_errno()) {

                $this->addError(mysqli_connect_error());

            }

        }

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $error
     *
     * @access private
     *
     * @return mixed
     */
    private function addError($error)
    {

        if (!$this->errors) {

            $this->errors = [];

            $this->errors[] = $error;

        }

    }

    /**
     * @param $table
     *
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns()
    {

        if (mysqli_num_rows(mysqli_query($this->dbConnection, "SHOW TABLES LIKE '$this->model'")) == 1) {

            $results = $this->dbConnection->query("SHOW COLUMNS FROM '$this->model'");

            if (mysqli_num_rows($results) > 0) {

                $this->filterTableColumns($results);

            }

        } else {

            $this->addError("There is no table found for this model.");

        }

    }


    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTableInfo()
    {
        return [
            'properties' => $this->properties,
            'methods' => $this->methods
        ];
    }


    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableProperties()
    {
        return $this->properties;
    }


    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableMethods()
    {
        return $this->methods;
    }

    /**
     * @access public
     */
    public function getModelTable()
    {

        return null;

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTablePrefix()
    {
        return null;
    }

    /**
     * @param $table
     *
     * @access public
     *
     * @return mixed
     */
    public function getTableSchemaManager()
    {
        return null;
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelDates()
    {
        return null;
    }

    /**
     * @param $columns
     *
     * @access public
     *
     * @return mixed
     */
    public function filterTableColumns($columns)
    {

        while ($column = mysqli_fetch_assoc($columns)) {

            $name = $this->getColumnName($column);

            if ($this->isColumnDate($column)) {

                $type = '\Carbon\Carbon';

            } else {

                $type = $this->filterTableFieldType($this->getColumnName($column));

            }

            $this->addProperty($name, $type, true, true);

            $this->addMethod(Str::camel("where_".$name), null, array('$value'));

        }

    }

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function getColumnName($column)
    {
        return $column['Field'];
    }

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function isColumnDate($column)
    {
        $type = $column['Type'];

        if (strpos($type, 'date') !== false || strpos($type, 'time') !== false) {

            return true;

        }

        return false;
    }

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function getColumnType($column)
    {
        return $this->filterTableFieldType($this->getColumnName($column));
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelClass()
    {
        return null;
    }

    /**
     * @param $type
     *
     * @access public
     *
     * @return mixed
     */
    public function filterTableFieldType($type)
    {

        if (strpos($type, 'string') !== false ||
            strpos($type, 'text') !== false ||
            strpos($type, 'date') !== false ||
            strpos($type, 'time') !== false ||
            strpos($type, 'guid') !== false ||
            strpos($type, 'datetimetz') !== false ||
            strpos($type, 'datetime') !== false) {

            return 'string';

        } elseif (strpos($type, 'integer') !== false ||
            strpos($type, 'bigint') !== false ||
            strpos($type, 'smallint') !== false) {

            return 'integer';

        } elseif (strpos($type, 'decimal') !== false ||
            strpos($type, 'float') !== false) {

            return 'float';

        } elseif (strpos($type, 'boolean') !== false) {

            return 'boolean';

        } elseif (strpos($type, 'mixed') !== false) {

            return 'mixed';

        }

        return '';
    }

    /**
     * @param      $name
     * @param null $type
     * @param null $read
     * @param null $write
     *
     * @access public
     *
     * @return mixed
     */
    public function addProperty($name, $type = null, $read = null, $write = null)
    {
        if (!isset($this->properties[$name])) {

            $this->properties[$name] = [
                'type' => 'mixed',
                'read' => false,
                'write' => false
            ];

        }

        if ($type !== null) {
            $this->properties[$name]['type'] = $type;
        }

        if ($read !== null) {
            $this->properties[$name]['read'] = $read;
        }

        if ($write !== null) {
            $this->properties[$name]['write'] = $write;
        }
    }

    /**
     * @param        $name
     * @param string $type
     * @param array  $arguments
     *
     * @access public
     *
     * @return mixed
     */
    public function addMethod($name, $type = '', $arguments = [])
    {
        if (!isset($this->methods[$name])) {

            $this->methods[$name] = [
                'type' => $type,
                'arguments' => $arguments
            ];

        }
    }
}
