<?php namespace Drivers\Database\Mysql;

use Helpers\ConfigHelper;
use Contracts\HelperInterface;
use mysqli;
use Helpers\StringHelper;
use Contracts\RepositoryInterface;
use SebastianBergmann\Exporter\Exception;

class MysqlRepository implements RepositoryInterface
{

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

    public function getTable($model)
    {

        if ($this->checkForTable($model)) {

            return $model;

        } elseif ($this->checkForTable(StringHelper::toPlural($model))) {

            return StringHelper::toPlural($model);

        } elseif ($this->checkForTable(StringHelper::toLower($model))) {

            return StringHelper::toLower($model);

        } elseif ($this->checkForTable(StringHelper::toPlural(StringHelper::toLower($model)))) {

            return StringHelper::toPlural(StringHelper::toLower($model));

        }

        return null;

    }

    public function checkForTable($model)
    {

        $result = $this->getDbConnection()->query("SHOW TABLES LIKE '".$model."'");

        if ($result->num_rows == 1) {

            return true;

        }

        return false;

    }

    public function getSchema()
    {

        return $this->config->getDatabase();

    }

    public function getColumns($model)
    {

        $result = $this->getDbConnection()->query("SHOW COLUMNS FROM ".$model);

        if ($result->num_rows > 0) {

            return $this->filterColumns($result);

        }

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

    /**
     * @param $columns
     *
     * @access public
     *
     * @return mixed
     */
    public function filterColumns($columns)
    {

        $columnsParsed = [];

        while ($column = $columns->fetch_assoc()) {

            $columnsParsed[$this->getColumnName($column)] = $column;

        }

        return $columnsParsed;

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

        if ($this->isColumnDate($column)) {

            return '\Carbon\Carbon';

        } else {

            return $this->helper->filterTableFieldType($column['Type']);

        }

    }

    public function getRequired($column)
    {

        if ($column['Null'] == 'NO') {

            return true;

        }

        return false;

    }

}

