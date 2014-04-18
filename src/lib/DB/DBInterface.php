<?php namespace DB;

/**
 * Interface DBInterface
 *
 * @package DB
 */
interface DBInterface
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
    public function getTableMethods();

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
    public function getModelTablePrefix();

    /**
     * @param $table
     *
     * @access public
     *
     * @return mixed
     */
    public function getTableSchemaManager($table);

    /**
     * @param $schema
     * @param $table
     *
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns($schema, $table);

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
    public function filterTableColumns($columns);

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
     * @access public
     *
     * @return mixed
     */
    public function getModelClass();

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

    /**
     * @param      $name
     * @param string $type
     * @param array $arguments
     *
     * @access public
     *
     * @return mixed
     */
    public function addMethod($name, $type = '', $arguments = []);

}

