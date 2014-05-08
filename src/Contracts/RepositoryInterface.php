<?php namespace Contracts;

/**
 * Interface RepositoryInterface
 *
 * @package Contracts
 */
interface RepositoryInterface
{

    /**
     * @return void
     */
    public function setDbConnection();

    /**
     * @return boolean
     */
    public function validateDbConnection();

    /**
     * @return mixed
     */
    public function getDbConnection();

    /**
     * @param $model
     *
     * @return mixed
     */
    public function getTable($model);

    /**
     * @param $model
     *
     * @return boolean
     */
    public function checkForTable($model);

    /**
     * @return string
     */
    public function getSchema();

    /**
     * @param $model
     *
     * @return mixed
     */
    public function getColumns($model);

    /**
     * @return mixed
     */
    public function getModelDates();

    /**
     * @param $columns
     *
     * @return mixed
     */
    public function filterColumns($columns);

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnName($column);

    /**
     * @param $column
     *
     * @return boolean
     */
    public function isColumnDate($column);

    /**
     * @param $column
     *
     * @return mixed
     */
    public function getColumnType($column);

    /**
     * @param $column
     *
     * @return boolean
     */
    public function isRequired($column);

}
