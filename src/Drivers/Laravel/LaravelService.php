<?php namespace Drivers\Laravel;

use Helpers\ServiceHelper;
use Illuminate\Database\Eloquent\Model;
use Contracts\ServicesInterface;

/**
 * Class LaravelService
 *
 * @package Services
 */
class LaravelService implements ServicesInterface
{

    /**
     * @var \Illuminate\Database\Eloquent\Model $model
     *
     * @access protected
     */
    protected $model;

    /**
     * @var \Contracts\HelperInterface $helper
     */
    protected $helper;

    /**
     * @access protected
     */
    protected $table = null;

    /**
     * @access protected
     */
    protected $schema = null;

    /**
     * @access protected
     */
    protected $columns = null;

    /**
     * @access protected
     */
    protected $properties = [];

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Helpers\ServiceHelper $helper
     *
     * @access public
     */
    public function __construct(Model $model, ServiceHelper $helper)
    {

        $this->model = $model;
        $this->helper = $helper;

    }

    /**
     * @return void
     */
    public function setDefaults()
    {

        $this->setTable();
        $this->setSchema();
        $this->setColumns();
        $this->filterTableColumns($this->model, $this->columns);

    }

    /**
     * @return boolean
     */
    public function validateDbConnection()
    {
        return false;
    }

    /**
     * @return void
     */
    public function setTable()
    {

        $this->table = $this->getModelTable();

    }

    /**
     * @return string
     */
    public function getTable()
    {

        return $this->table;

    }

    /**
     * @return void
     */
    public function setSchema()
    {

        $this->schema = $this->getTableSchemaManager();

    }

    /**
     * @return string
     */
    public function getSchema()
    {

        return $this->schema;

    }

    /**
     * @return void
     */
    public function setColumns()
    {

        $this->columns = $this->getTableColumns();

    }

    /**
     * @return mixed
     */
    public function getColumns()
    {

        return $this->columns;

    }

    /**
     * @return mixed
     */
    public function getProperties()
    {

        if (!$this->table) {

            $this->setDefaults();

        }

        return $this->properties;

    }

    /**
     * @return mixed
     */
    public function getModelTableInfo()
    {
        return [
            'properties' => $this->getProperties()
        ];
    }


    /**
     * @return mixed
     */
    public function getTableProperties()
    {
        return $this->getProperties();
    }

    /**
     * @return string
     */
    public function getModelTable()
    {

        return $this->model->getTable();

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableSchemaManager()
    {
        return $this->model->getConnection()->getDoctrineSchemaManager($this->table);
    }

    /**
     * @return mixed
     */
    public function getTableColumns()
    {
        $this->schema->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        return $this->schema->listTableColumns($this->table);
    }

    /**
     * @return mixed
     */
    public function getModelDates()
    {
        return $this->model->getDates();
    }

    /**
     * @return void
     */
    public function filterTableColumns()
    {

        if ($this->columns) {

            $modelDates = $this->getModelDates($this->model);

            foreach ($this->columns as $name => $column) {

                if (in_array($name, $modelDates)) {

                    $type = '\Carbon\Carbon';

                } else {

                    $name = $this->getColumnName($column);

                    $type = $this->helper->filterTableFieldType($this->getColumnType($column));

                }

                $this->addProperty($name, $type, false, true, true);

            }

        }

    }

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnName($column)
    {
        return $column->getName();
    }

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnType($column)
    {
        return $column->getType()->getName();
    }

    /**
     * @param      $name
     * @param string $type
     * @param boolean $required
     * @param boolean $read
     * @param boolean $write
     *
     * @return void
     */
    public function addProperty($name, $type = null, $required = false, $read = false, $write = false)
    {

        $this->setProperty($name);
        $this->setPropertyType($name, $type);
        $this->setPropertyRead($name, $read);
        $this->setPropertyWrite($name, $write);
        $this->setPropertyRequired($name, $required);

    }

    /**
     * @param $name
     *
     * @return void
     */
    public function setProperty($name)
    {

        if (!isset($this->properties[$name])) {

            $this->properties[$name] = [];

        }

    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getProperty($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name];

        }

        return null;

    }

    /**
     * @param        $name
     * @param string $type
     *
     * @return void
     */
    public function setPropertyType($name, $type = 'mixed')
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['type'] = $type;

        }

        return null;

    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getPropertyType($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['type'];

        }

        return null;

    }

    /**
     * @param $name
     * @param $read
     *
     * @return void
     */
    public function setPropertyRead($name, $read)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['read'] = $read;

        }

        return null;

    }

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyRead($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['read'];

        }

        return null;

    }

    /**
     * @param $name
     * @param $write
     *
     * @return void
     */
    public function setPropertyWrite($name, $write)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['write'] = $write;

        }

        return null;

    }

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyWrite($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['write'];

        }

        return null;

    }

    /**
     * @param $name
     * @param $required
     *
     * @return void
     */
    public function setPropertyRequired($name, $required)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['required'] = $required;

        }

        return null;

    }

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyRequired($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['required'];

        }

        return null;

    }

}
