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

    public function getModelTable();

    public function getTableSchemaManager();

    public function getModelDates();

    public function filterTableColumns();

    public function getColumnName($column);

    public function isColumnDate($column);

    public function getColumnType($column);

    public function isRequired($column);

    public function filterTableFieldType($type);

    public function addProperty($name, $type = null, $required = false, $read = null, $write = null);

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
