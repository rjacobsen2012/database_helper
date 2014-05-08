<?php namespace Drivers\Database\Mysql;

use Drivers\Database\DatabaseConfig;
use Contracts\HelperInterface;
use mysqli;
use Contracts\RepositoryInterface;
use Illuminate\Support\Str;

/**
 * Class MysqlRepository
 *
 * @package Drivers\Database\Mysql
 */
class MysqlRepository implements RepositoryInterface
{

    /**
     * @var \Drivers\Database\DatabaseConfig $helper
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

    public function __construct(mysqli $mysql, DatabaseConfig $config, HelperInterface $helper)
    {

        $this->helper = $helper;
        $this->config = $config;
        $this->db = $mysql;

    }

    /**
     * @return void
     */
    public function setDbConnection()
    {

        $this->db->real_connect(
            $this->config->getHost(),
            $this->config->getUser(),
            $this->config->getPassword(),
            $this->config->getDatabase(),
            $this->config->getPort(),
            $this->config->getSocket()
        );
        $this->dbConnection = $this->db;

    }

    /**
     * @return boolean
     */
    public function validateDbConnection()
    {

        $this->setDbConnection();

        if ($this->getDbConnection()) {

            return true;

        }

        return false;

    }

    /**
     * @return mixed
     */
    public function getDbConnection()
    {

        return $this->dbConnection;

    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function getTable($model)
    {

        if ($this->checkForTable($model)) {

            return $model;

        } elseif ($this->checkForTable(Str::plural($model))) {

            return Str::plural($model);

        } elseif ($this->checkForTable(strtolower($model))) {

            return strtolower($model);

        } elseif ($this->checkForTable(Str::plural(strtolower($model)))) {

            return Str::plural(strtolower($model));

        }

        return null;

    }

    /**
     * @param $model
     *
     * @return boolean
     */
    public function checkForTable($model)
    {

        $result = $this->getDbConnection()->query("SHOW TABLES LIKE '".$model."'");

        if ($result->num_rows == 1) {

            return true;

        }

        return false;

    }

    /**
     * @return string
     */
    public function getSchema()
    {

        return $this->config->getDatabase();

    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function getColumns($model)
    {

        $result = $this->getDbConnection()->query("SHOW COLUMNS FROM ".$model);

        if ($result->num_rows > 0) {

            return $this->filterColumns($result);

        }

        return null;

    }

    /**
     * @return mixed
     */
    public function getModelDates()
    {
        return null;
    }

    /**
     * @param $columns
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

    /**
     * @param $column
     *
     * @return string
     */
    public function getColumnName($column)
    {
        return $column['Field'];
    }

    /**
     * @param $column
     *
     * @return boolean
     */
    public function isColumnDate($column)
    {

        $type = $column['Type'];

        if (strpos($type, 'date') !== false || strpos($type, 'time') !== false) {

            return true;

        }

        return false;

    }

    /**
     * @param $column
     *
     * @return mixed
     */
    public function getColumnType($column)
    {

        if ($this->isColumnDate($column)) {

            return '\Carbon\Carbon';

        } else {

            return $this->helper->filterTableFieldType($column['Type']);

        }

    }

    /**
     * @param $column
     *
     * @return boolean
     */
    public function isRequired($column)
    {

        if ($column['Null'] == 'NO') {

            return true;

        }

        return false;

    }

}

