<?php namespace DatabaseHelpers;

use Illuminate\Database\Eloquent\Model;
use DB\DBInterface;
use Illuminate\Support\Str;

/**
 * Class LaravelHelper
 *
 * @package DatabaseHelpers
 */
class LaravelHelper implements DBInterface
{

    /**
     * @var \Illuminate\Database\Eloquent\Model $model
     *
     * @access protected
     */
    protected $model;

    /**
     * @access protected
     */
    protected $properties = [];

    /**
     * @access protected
     */
    protected $methods = [];

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @access public
     */
    public function __construct(Model $model)
    {
        /** @param \Illuminate\Database\Eloquent\Model $model */
        $this->model = $model;

        $table = $this->getModelTable($this->model);
        $schema = $this->getTableSchemaManager($this->model, $table);
        $columns = $this->getTableColumns($schema, $table);

        $this->filterTableColumns($this->model, $columns);
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
     * @access private
     */
    public function getModelTable()
    {

        /** @param \Illuminate\Database\Eloquent\Model $model */
        return $this->model->getTable();

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTablePrefix()
    {
        /** @param \Illuminate\Database\Eloquent\Model $model */
        return $this->model->getConnection()->getTablePrefix;
    }

    /**
     * @param $table
     *
     * @access public
     *
     * @return mixed
     */
    public function getTableSchemaManager($table)
    {
        /** @param \Illuminate\Database\Eloquent\Model $model */
        return $this->model->getConnection()->getDoctrineSchemaManager($table);
    }

    /**
     * @param $schema
     * @param $table
     *
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns($schema, $table)
    {
        $schema->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        return $schema->listTableColumns($table);
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelDates()
    {
        /** @param \Illuminate\Database\Eloquent\Model $model */
        return $this->model->getDates();
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

        if ($columns) {

            $modelDates = $this->getModelDates($this->model);

            foreach ($columns as $column) {

                $name = $this->getColumnName($column);

                if (in_array($name, $modelDates)) {

                    $type = '\Carbon\Carbon';

                } else {

                    $type = $this->filterTableFieldType($this->getColumnName($column));

                }

                $this->addProperty($name, $type, true, true);

                $this->addMethod(Str::camel("where_".$name), $this->getModelClass($this->model), array('$value'));

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
        return $column->getName();
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
        // TODO: Implement getColumnType() method.
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
        switch ($type) {
            case 'string':
            case 'text':
            case 'date':
            case 'time':
            case 'guid':
            case 'datetimetz':
            case 'datetime':
                return 'string';
                break;
            case 'integer':
            case 'bigint':
            case 'smallint':
                return 'integer';
                break;
            case 'decimal':
            case 'float':
                return 'float';
                break;
            case 'boolean':
                return 'boolean';
                break;
            default:
                return 'mixed';
                break;
        }
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
