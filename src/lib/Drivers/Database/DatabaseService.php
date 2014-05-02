<?php namespace Drivers\Database;

use Contracts\HelperInterface;
use Contracts\RepositoryInterface;
use Contracts\ServicesInterface;
use Helpers\DatabaseHelper;
use Helpers\ServiceHelper;

/**
 * Class DatabaseHelper
 *
 * @package DatabaseHelpers
 */
class DatabaseService implements ServicesInterface
{

    /**
     * @var $model
     */
    protected $model = null;

    /**
     * @var $table
     */
    protected $table = null;

    /**
     * @access protected
     */
    protected $columns = null;

    /**
     * @access protected
     */
    protected $properties = null;

    /**
     * @access protected
     */
    protected $schema = null;

    /**
     * @access protected
     */
    protected $helper;

    /**
     * @access protected
     *
     * @var \Contracts\RepositoryInterface|resource $repository
     *
     */
    protected $repository;

    /**
     * @param string                                $model
     * @param \Contracts\HelperInterface            $helper
     * @param \Contracts\RepositoryInterface        $repository
     *
     * @access public
     */
    public function __construct($model, HelperInterface $helper, RepositoryInterface $repository)
    {

        $this->model = $model;
        $this->helper = $helper;
        $this->repository = $repository;

    }

    public function testDbConnectionFails()
    {

        return $this->repository->testDbConnectionFails();

    }

    public function setDefaults()
    {

        $this->repository->setDbConnection();
        $this->setTable();
        $this->setSchema();
        $this->setColumns();
        $this->filterTableColumns();

    }

    public function setTable()
    {

        $this->table = $this->repository->getTable($this->model);

        if (!$this->table) {

            throw new \Exception("[{$this->model}] table was not found.");

        }

    }

    public function getTable()
    {

        return $this->table;

    }

    public function setSchema()
    {

        $this->schema = $this->repository->getSchema();

    }

    public function getSchema()
    {

        return $this->schema;

    }

    public function setColumns()
    {

        $this->columns = $this->repository->getColumns($this->table);

    }

    public function getColumns()
    {

        return $this->columns;

    }

    public function getProperties()
    {

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
     * @access public
     *
     * @return mixed
     */
    public function getModelTable()
    {
        return $this->table;
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableSchemaManager()
    {
        return $this->repository->getTableSchemaManager();
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns()
    {

        return $this->getColumns($this->model);

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelDates()
    {
        return $this->repository->getModelDates();
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

        foreach ($this->columns as $field => $column) {

            $this->addProperty(
                $this->getColumnName($column),
                $this->getColumnType($column),
                $this->getColumnRequired($column),
                true,
                true
            );

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
        return $this->repository->getColumnName($column);
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
        return $this->repository->getColumnType($column);
    }

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function getColumnRequired($column)
    {
        return $this->repository->getRequired($column);
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
    public function addProperty($name, $type = null, $required = false, $read = null, $write = null)
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

        return $this->properties[$name];

    }

    public function setPropertyType($name, $type = 'mixed')
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['type'] = $type;

        }

    }

    public function getPropertyType($name)
    {

        return $this->properties[$name]['type'];

    }

    public function setPropertyRead($name, $read)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['read'] = $read;

        }

    }

    public function getPropertyRead($name)
    {

        return $this->properties[$name]['read'];

    }

    public function setPropertyWrite($name, $write)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['write'] = $write;

        }

    }

    public function getPropertyWrite($name)
    {

        return $this->properties[$name]['write'];

    }

    public function setPropertyRequired($name, $required)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['required'] = $required;

        }

    }

    public function getPropertyRequired($name)
    {

        return $this->properties[$name]['required'];

    }

}
