<?php namespace DatabaseHelpers;

use Illuminate\Exception;
use DB\DBInterface;
use Illuminate\Support\Str;
use DatabaseHelpers\Databases\MysqliRepository;

/**
 * Class DatabaseHelper
 *
 * @package DatabaseHelpers
 */
class MysqlHelper implements DBInterface
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
    public function __construct($model, $dbConnection)
    {

        $this->model = $model;
        $this->dbConnection = $dbConnection;
        $this->getTableColumns();

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

        $columnsFound = MysqliRepository::getTableColumns($this->model, $this->dbConnection);

        if ($columnsFound) {

            $this->filterTableColumns($columnsFound);

        } else {

            throw new ExceptionHandler("[{$this->model}] table was not found.");

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

        while ($column = $columns->fetch_assoc()) {

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
