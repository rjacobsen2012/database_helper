<?php namespace Drivers\Laravel;

use Helpers\LaravelHelper;
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
     *
     * @access public
     */
    public function __construct(Model $model, LaravelHelper $helper)
    {

        $this->model = $model;
        $this->helper = $helper;

    }

    public function setDefaults()
    {

        $this->setTable();
        $this->setSchema();
        $this->setColumns();
        $this->filterTableColumns($this->model, $this->columns);

    }

    public function testDbConnectionFails()
    {
        return false;
    }

    public function setTable()
    {

        $this->table = $this->getModelTable();

    }

    public function getTable()
    {

        return $this->table;

    }

    public function setSchema()
    {

        $this->schema = $this->getTableSchemaManager();

    }

    public function getSchema()
    {

        return $this->schema;

    }

    public function setColumns()
    {

        $this->columns = $this->getTableColumns();

    }

    public function getColumns()
    {

        return $this->columns;

    }

    public function getProperties()
    {

        if (!$this->table) {

            $this->setDefaults();

        }

        return $this->properties;

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTableInfo()
    {
        return [
            'properties' => $this->getProperties()
        ];
    }


    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableProperties()
    {
        return $this->getProperties();
    }

    /**
     * @access private
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
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns()
    {
        $this->schema->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        return $this->schema->listTableColumns($this->table);
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelDates()
    {
        return $this->model->getDates();
    }

    /**
     * @param $columns
     *
     * @access public
     *
     * @return mixed
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
        return $column->getType()->getName();
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
    public function addProperty($name, $type = null, $required = false, $read = false, $write = false)
    {

        $this->setProperty($name);
        $this->setPropertyType($name, $type);
        $this->setPropertyRead($name, $read);
        $this->setPropertyWrite($name, $write);
        $this->setPropertyRequired($name, $required);

    }

    public function setProperty($name)
    {

        if (!isset($this->properties[$name])) {

            $this->properties[$name] = [];

        }

    }

    public function getProperty($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name];

        }

        return null;

    }

    public function setPropertyType($name, $type = 'mixed')
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['type'] = $type;

        }

        return null;

    }

    public function getPropertyType($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['type'];

        }

        return null;

    }

    public function setPropertyRead($name, $read)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['read'] = $read;

        }

        return null;

    }

    public function getPropertyRead($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['read'];

        }

        return null;

    }

    public function setPropertyWrite($name, $write)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['write'] = $write;

        }

        return null;

    }

    public function getPropertyWrite($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['write'];

        }

        return null;

    }

    public function setPropertyRequired($name, $required)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['required'] = $required;

        }

        return null;

    }

    public function getPropertyRequired($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['required'];

        }

        return null;

    }

}
