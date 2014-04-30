<?php namespace Drivers\Database;

use Contracts\HelperInterface;
use Contracts\RepositoryInterface;
use Contracts\ServicesInterface;

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
    protected $model;

    /**
     * @access protected
     *
     * @var \Contracts\RepositoryInterface|resource $repository
     *
     */
    protected $repository;

    /**
     * @param string                 $model
     * @param \Contracts\RepositoryInterface     $repository
     * @param \Contracts\HelperInterface              $helper
     *
     * @access public
     */
    public function __construct($model, RepositoryInterface $repository)
    {

        $this->model = $model;
        $this->repository = $repository;

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns()
    {

        return $this->repository->getTableColumns($this->model);

    }


    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTableInfo()
    {
        return $this->repository->getModelTableInfo();
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableProperties()
    {
        return $this->repository->getTableProperties();
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTable()
    {
        return $this->repository->getModelTable();
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
        return $this->repository->filterTableColumns();
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
     * @param $type
     *
     * @access public
     *
     * @return mixed
     */
    public function filterTableFieldType($type)
    {
        return $this->repository->filterTableFieldType($type);
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
        return $this->repository->addProperty($name, $type, $read, $write);
    }

    public function setProperty($name)
    {

        return $this->repository->setProperty($name);

    }

    public function getProperty($name)
    {

        return $this->repository->getProperty($name);

    }

    public function setPropertyType($name, $type = 'mixed')
    {

        return $this->repository->setPropertyType($name, $type);

    }

    public function getPropertyType($name)
    {

        return $this->repository->getPropertyType($name);

    }

    public function setPropertyRead($name, $read)
    {

        return $this->repository->setPropertyRead($name, $read);

    }

    public function getPropertyRead($name)
    {

        return $this->repository->getPropertyRead($name);

    }

    public function setPropertyWrite($name, $write)
    {

        return $this->repository->setPropertyWrite($name, $write);

    }

    public function getPropertyWrite($name)
    {

        return $this->repository->getPropertyWrite($name);

    }

    public function setPropertyRequired($name, $required)
    {

        return $this->repository->setPropertyRequired($name, $required);

    }

    public function getPropertyRequired($name)
    {

        return $this->repository->getPropertyRequired($name);

    }

}
