<?php namespace Drivers\Database\Mysql;

use Helpers\ConfigHelper;
use Contracts\HelperInterface;
use mysqli;
use Helpers\StringHelper;
use Contracts\RepositoryInterface;

class MysqlRepository implements RepositoryInterface
{

    /**
     * @access protected
     */
    protected $model;

    /**
     * @var \Helpers\HelperInterface $helper
     */
    protected $helper;

    /**
     * @access protected
     */
    protected $table = null;

    /**
     * @access protected
     */
    protected $config;

    /**
     * @access protected
     */
    protected $schema;

    /**
     * @access protected
     */
    protected $properties = [];

    /**
     * @access protected
     */
    protected $methods = [];

    protected $dbConnection = null;

    protected $db = null;

    public function __construct(mysqli $mysql, ConfigHelper $config, HelperInterface $helper)
    {

        $this->helper = $helper;
        $this->config = $config;
        $this->db = $mysql;

    }

    public function setDbConnection()
    {

        $this->dbConnection = $this->db->real_connect(
            $this->config->getHost(),
            $this->config->getUser(),
            $this->config->getPassword(),
            $this->config->getDatabase(),
            $this->config->getPort(),
            $this->config->getSocket()
        );

    }

    public function getDbConnection()
    {

        if (!$this->dbConnection instanceof mysqli) {

            $this->setDbConnection();

        }

        return $this->dbConnection;

    }

    public function getTableColumns($model)
    {

        if ($this->checkForTable($model)) {

            return $this->getColumns($model);

        } elseif ($this->checkForTable(StringHelper::toLower($model))) {

            return $this->getColumns(StringHelper::toLower($model));

        } else {

            throw new \Exception("[{$model}] table was not found.");

        }

    }

    public function getColumns($model)
    {

        $result = $this->getDbConnection()->query("SHOW COLUMNS FROM ".$model);

        if ($result->num_rows > 0) {

            return $result;

        }

        return null;

    }

    public function checkForTable($model)
    {

        $result = $this->getDbConnection()->query("SHOW TABLES LIKE '".$model."'");

        if ($result->num_rows == 1) {

            $this->table = $model;
            return true;

        }

        return false;

    }

    public function getModelTableInfo()
    {

        return [
            'properties' => $this->properties,
            'methods' => $this->methods
        ];

    }

    public function getTableProperties()
    {
        return $this->properties;
    }

    public function getTableMethods()
    {
        return $this->methods;
    }

    public function getModelTable()
    {
        return $this->table;
    }

    public function getModelTablePrefix()
    {
        return null;
    }

    public function getTableSchemaManager()
    {
        return null;
    }

    public function getModelDates()
    {
        return null;
    }

    public function filterTableColumns($columns)
    {

        while ($column = $columns->fetch_assoc()) {

            $name = $this->getColumnName($column);

            if ($this->isColumnDate($column)) {

                $type = '\Carbon\Carbon';

            } else {

                $type = $this->filterTableFieldType($this->getColumnType($column));

            }

            $this->addProperty($name, $type, $this->isRequired($column), true, true);

            $this->addMethod(StringHelper::toCamel("where_".$name), $this->getColumnType($column), array('$value'));

        }

    }

    public function getColumnName($column)
    {
        return $column['Field'];
    }

    public function isColumnDate($column)
    {
        $type = $column['Type'];

        if (strpos($type, 'date') !== false || strpos($type, 'time') !== false) {

            return true;

        }

        return false;
    }

    public function getColumnType($column)
    {
        return $column['Type'];
    }

    public function isRequired($column)
    {

        if ($column['Null'] == 'NO') {

            return true;

        }

        return false;

    }

    public function getModelClass()
    {
        return null;
    }

    public function filterTableFieldType($type)
    {

        switch ($type) {

            case $this->helper->isString($type):

                return 'string';

                break;

            case $this->helper->isInteger($type):

                return 'integer';

                break;

            case $this->helper->isDecimal($type):

                return 'float';

                break;

            case $this->helper->isBoolean($type):

                return 'boolean';

                break;

            case $this->helper->isMixed($type):

                return 'mixed';

                break;

            default:

                return '';

        }

    }

    public function addProperty($name, $type = null, $required = false, $read = null, $write = null)
    {

        if (!isset($this->properties[$name])) {

            $this->properties[$name] = [
                'type' => 'mixed',
                'read' => false,
                'write' => false,
                'required' => $required
            ];

        }

        if ($type !== null) {
            $this->properties[$name]['type'] = $type;
        }

        if ($read !== null) {
            $this->properties[$name]['read'] = $read;
        }

        if ($write !== null) {
            $this->properties[$name]['write'] = $write;
        }

    }

    public function addMethod($name, $type = '', $arguments = [])
    {

        if (!isset($this->methods[$name])) {

            $this->methods[$name] = [
                'type' => $type,
                'arguments' => $arguments
            ];

        }

    }
}

