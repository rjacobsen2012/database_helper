<?php namespace Contracts;

/**
 * Interface ServicesInterface
 *
 * @package Services
 */
interface ServicesInterface
{

    /**
     * @return void
     */
    public function setDefaults();

    /**
     * @return boolean
     */
    public function validateDbConnection();

    /**
     * @return void
     */
    public function setTable();

    /**
     * @return string
     */
    public function getTable();

    /**
     * @return void
     */
    public function setSchema();

    /**
     * @return string
     */
    public function getSchema();

    /**
     * @return void
     */
    public function setColumns();

    /**
     * @return mixed
     */
    public function getColumns();

    /**
     * @return mixed
     */
    public function getProperties();

    /**
     * @return mixed
     */
    public function getModelTableInfo();

    /**
     * @return mixed
     */
    public function getTableProperties();

    /**
     * @return string
     */
    public function getModelTable();

    /**
     * @return mixed
     */
    public function getTableColumns();

    /**
     * @return mixed
     */
    public function getModelDates();

    /**
     * @return void
     */
    public function filterTableColumns();

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnName($column);

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnType($column);

    /**
     * @param      $name
     * @param string $type
     * @param boolean $required
     * @param boolean $read
     * @param boolean $write
     *
     * @return void
     */
    public function addProperty($name, $type = null, $required = false, $read = null, $write = null);

    /**
     * @param $name
     *
     * @return void
     */
    public function setProperty($name);

    /**
     * @param $name
     *
     * @return string
     */
    public function getProperty($name);

    /**
     * @param        $name
     * @param string $type
     *
     * @return void
     */
    public function setPropertyType($name, $type = 'mixed');

    /**
     * @param $name
     *
     * @return string
     */
    public function getPropertyType($name);

    /**
     * @param $name
     * @param $read
     *
     * @return void
     */
    public function setPropertyRead($name, $read);

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyRead($name);

    /**
     * @param $name
     * @param $write
     *
     * @return void
     */
    public function setPropertyWrite($name, $write);

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyWrite($name);

    /**
     * @param $name
     * @param $required
     *
     * @return void
     */
    public function setPropertyRequired($name, $required);

    /**
     * @param $name
     *
     * @return boolean
     */
    public function isPropertyRequired($name);

}

