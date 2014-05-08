<?php namespace Drivers\Database;

use Contracts\HelperInterface;
use Contracts\RepositoryInterface;
use Contracts\ServicesInterface;
use Helpers\ServiceHelper;

/**
 * Class DatabaseService
 *
 * @package DatabaseService
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

    /**
     * @return void
     */
    public function setDefaults()
    {

        $this->repository->setDbConnection();
        $this->setTable();
        $this->setSchema();
        $this->setColumns();
        $this->filterTableColumns();

    }

    /**
     * @return boolean
     */
    public function validateDbConnection()
    {

        return $this->repository->validateDbConnection();

    }

    /**
     * @return void
     */
    public function setTable()
    {

        $this->table = $this->repository->getTable($this->model);

        if (!$this->table) {

            throw new \Exception("[{$this->model}] table was not found.");

        }

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

        $this->schema = $this->repository->getSchema();

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

        $this->columns = $this->repository->getColumns($this->table);

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
        return $this->table;
    }

    /**
     * @return mixed
     */
    public function getTableColumns()
    {

        return $this->getColumns($this->model);

    }

    /**
     * @return mixed
     */
    public function getModelDates()
    {
        return $this->repository->getModelDates();
    }

    /**
     * @return void
     */
    public function filterTableColumns()
    {

        foreach ($this->columns as $field => $column) {

            $this->addProperty(
                $this->getColumnName($column),
                $this->getColumnType($column),
                $this->isColumnRequired($column),
                true,
                true
            );

        }

    }

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnName($column)
    {
        return $this->repository->getColumnName($column);
    }

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnType($column)
    {
        return $this->repository->getColumnType($column);
    }

    /**
     * @param $column
     *
     * @return boolean
     */
    public function isColumnRequired($column)
    {
        return $this->repository->isRequired($column);
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
    public function addProperty($name, $type = null, $required = false, $read = null, $write = null)
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

        return $this->properties[$name];

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

    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getPropertyType($name)
    {

        return $this->properties[$name]['type'];

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

    }

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyRead($name)
    {

        return $this->properties[$name]['read'];

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

    }

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyWrite($name)
    {

        return $this->properties[$name]['write'];

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

    }

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyRequired($name)
    {

        return $this->properties[$name]['required'];

    }

}
