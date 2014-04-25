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
     * @var \Contracts\HelperInterface $helper
     */
    protected $helper;

    /**
     * @param string                 $model
     * @param \Contracts\RepositoryInterface     $repository
     * @param \Contracts\HelperInterface              $helper
     *
     * @access public
     */
    public function __construct($model, RepositoryInterface $repository, HelperInterface $helper)
    {

        $this->model = $model;
        $this->repository = $repository;
        $this->helper = $helper;

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns()
    {

        $this->repository->getTableColumns($this->model);

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
    public function getTableMethods()
    {
        return $this->repository->getTableMethods();
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
    public function getModelTablePrefix()
    {
        return $this->repository->getModelTablePrefix();
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
    public function filterTableColumns($columns)
    {
        return $this->repository->filterTableColumns($columns);
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
     * @access public
     *
     * @return mixed
     */
    public function getModelClass()
    {
        return $this->repository->getModelClass();
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
        return $this->repository->addMethod($name, $type, $arguments);
    }
}
