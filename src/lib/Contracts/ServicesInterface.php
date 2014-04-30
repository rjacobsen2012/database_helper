<?php namespace Contracts;

/**
 * Interface ServicesInterface
 *
 * @package Services
 */
interface ServicesInterface
{

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTableInfo();

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableProperties();

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTable();

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableSchemaManager();

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns();

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelDates();

    /**
     * @param $columns
     *
     * @access public
     *
     * @return mixed
     */
    public function filterTableColumns();

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function getColumnName($column);

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function getColumnType($column);

    /**
     * @param $type
     *
     * @access public
     *
     * @return mixed
     */
    public function filterTableFieldType($type);

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
    public function addProperty($name, $type = null, $read = null, $write = null);

    public function setProperty($name);

    public function getProperty($name);

    public function setPropertyType($name, $type = 'mixed');

    public function getPropertyType($name);

    public function setPropertyRead($name, $read);

    public function getPropertyRead($name);

    public function setPropertyWrite($name, $write);

    public function getPropertyWrite($name);

    public function setPropertyRequired($name, $required);

    public function getPropertyRequired($name);

}

