<?php namespace Contracts;

use Helpers\ConfigHelper;
use mysqli;

interface RepositoryInterface
{

    public function setDbConnection();

    public function getDbConnection();

    public function testDbConnectionFails();

    public function getTable($model);

    public function checkForTable($model);

    public function getSchema();

    public function getColumns($model);

    public function getTableSchemaManager();

    public function getModelDates();

    public function getColumnName($column);

    public function isColumnDate($column);

    public function getColumnType($column);

    public function getRequired($column);

}
