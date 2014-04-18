<?php namespace DatabaseHelpers\Databases;

use DB\DBInterface;
use Illuminate\Support\Facades\Config;
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
    protected $schema;

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
     * @param Database Connection   $dbConnection
     *
     * @access public
     */
    public function __construct($model, $dbConnection)
    {
        $this->model = strtolower($model);
        $this->dbConnection = $dbConnection;
        $columns = $this->getTableColumns();

        $this->filterTableColumns($this->model, $columns);
    }

    /**
     * @param $query
     *
     * @access public
     *
     * @return mixed
     */
    public function dbQuery($query)
    {

        mysql_connect(
            $this->dbConnection['hostname'],
            $this->dbConnection['user'],
            $this->dbConnection['password']
        );

        mysql_select_db($this->dbConnection['database']);

        return mysql_query($query);

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

        $result = $this->dbQuery("SHOW COLUMNS FROM sometable");

        if (!$result) {

            echo 'Could not run query: ' . mysql_error();

            exit;

        }



        if (mysql_num_rows($result) > 0) {

            while ($row = mysql_fetch_assoc($result)) {

                $this->addProperty($row['Field'], $row['Type'], true, true);

            }

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

        if (mysql_num_rows($columns) > 0) {

            while ($column = mysql_fetch_assoc($columns)) {

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
        /** @param \Illuminate\Database\Eloquent\Model $model */
        return '\Illuminate\Database\Query\Builder|\\'.get_class($this->model);
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
