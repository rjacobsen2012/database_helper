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
    protected $columns;

    /**
     * @access protected
     */
    protected $properties = [];

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

            $this->columns = $result;
            return $this->columns;

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
            'properties' => $this->properties
        ];

    }

    public function getTableProperties()
    {
        return $this->properties;
    }

    public function getModelTable()
    {
        return $this->table;
    }

    public function getTableSchemaManager()
    {
        return null;
    }

    public function getModelDates()
    {
        return null;
    }

    public function fetchRow()
    {

        return $this->columns->fetch_assoc();

    }

    public function filterTableColumns()
    {

        while ($column = $this->fetchRow()) {

            $name = $this->getColumnName($column);

            if ($this->isColumnDate($column)) {

                $type = '\Carbon\Carbon';

            } else {

                $type = $this->filterTableFieldType($this->getColumnType($column));

            }

            $this->addProperty($name, $type, $this->isRequired($column), true, true);

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

        $this->setProperty($name);
        $this->setPropertyType($name, $type);
        $this->setPropertyRead($name, $read);
        $this->setPropertyWrite($name, $write);
        $this->setPropertyRequired($name, $required);

    }

    public function setProperty($name)
    {

        if (!isset($this->properties[$name])) {

            $this->properties[$name] = [];

        }

    }

    public function getProperty($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name];

        }

        return null;

    }

    public function setPropertyType($name, $type = 'mixed')
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['type'] = $type;

        }

        return null;

    }

    public function getPropertyType($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['type'];

        }

        return null;

    }

    public function setPropertyRead($name, $read)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['read'] = $read;

        }

        return null;

    }

    public function getPropertyRead($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['read'];

        }

        return null;

    }

    public function setPropertyWrite($name, $write)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['write'] = $write;

        }

        return null;

    }

    public function getPropertyWrite($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['write'];

        }

        return null;

    }

    public function setPropertyRequired($name, $required)
    {

        if (isset($this->properties[$name])) {

            $this->properties[$name]['required'] = $required;

        }

        return null;

    }

    public function getPropertyRequired($name)
    {

        if (isset($this->properties[$name])) {

            return $this->properties[$name]['required'];

        }

        return null;

    }

}

