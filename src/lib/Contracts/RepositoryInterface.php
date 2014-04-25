<?php namespace Contracts;

use Helpers\ConfigHelper;
use mysqli;

interface RepositoryInterface
{

    public function __construct(mysqli $mysql, ConfigHelper $config, HelperInterface $helper);

    public function setDbConnection();

    public function getDbConnection();

    public function getTableColumns($model);

    public function getModelTableInfo();

    public function getTableProperties();

    public function getTableMethods();

    public function getModelTable();

    public function getModelTablePrefix();

    public function getTableSchemaManager();

    public function getModelDates();

    public function filterTableColumns($columns);

    public function getColumnName($column);

    public function isColumnDate($column);

    public function getColumnType($column);

    public function isRequired($column);

    public function getModelClass();

    public function filterTableFieldType($type);

    public function addProperty($name, $type = null, $required = false, $read = null, $write = null);

    public function addMethod($name, $type = '', $arguments = []);

}
