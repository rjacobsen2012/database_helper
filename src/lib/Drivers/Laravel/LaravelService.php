<?php namespace Drivers\Laravel;

use Illuminate\Database\Eloquent\Model;
use Contracts\ServicesInterface;
use Helpers\StringHelper;

/**
 * Class LaravelService
 *
 * @package Services
 */
class LaravelService implements ServicesInterface
{

    /**
     * @var \Illuminate\Database\Eloquent\Model $model
     *
     * @access protected
     */
    protected $model;

    /**
     * @var \Contracts\HelperInterface $helper
     */
    protected $helper;

    /**
     * @access protected
     */
    protected $table = null;

    /**
     * @access protected
     */
    protected $schema = null;

    /**
     * @access protected
     */
    protected $properties = [];

    /**
     * @access protected
     */
    protected $methods = [];

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @access public
     */
    public function __construct(Model $model, LaravelHelper $helper)
    {

        $this->model = $model;
        $this->helper = $helper;

    }

    public function setDefaults()
    {

        $this->table = $this->getModelTable();
        $this->schema = $this->getTableSchemaManager();
        $columns = $this->getTableColumns();
        $this->filterTableColumns($this->model, $columns);

    }

    public function getProperties()
    {

        if (!$this->table) {

            $this->setDefaults();

        }

        return $this->properties;

    }

    public function getMethods()
    {

        if (!$this->table) {

            $this->setDefaults();

        }

        return $this->methods;

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTableInfo()
    {
        return [
            'properties' => $this->getProperties(),
            'methods' => $this->getMethods()
        ];
    }


    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableProperties()
    {
        return $this->getProperties();
    }


    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableMethods()
    {
        return $this->getMethods();
    }

    /**
     * @access private
     */
    public function getModelTable()
    {

        return $this->model->getTable();

    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelTablePrefix()
    {
        return $this->model->getConnection()->getTablePrefix;
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableSchemaManager()
    {
        return $this->model->getConnection()->getDoctrineSchemaManager($this->table);
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getTableColumns()
    {
        $this->schema->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        return $this->schema->listTableColumns($this->table);
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelDates()
    {
        return $this->model->getDates();
    }

    /**
     * @param $columns
     *
     * @access public
     *
     * @return mixed
     */
    public function filterTableColumns($columns)
    {

        if ($columns) {

            $modelDates = $this->getModelDates($this->model);

            foreach ($columns as $column) {

                $name = $this->getColumnName($column);

                if (in_array($name, $modelDates)) {

                    $type = '\Carbon\Carbon';

                } else {

                    $type = $this->filterTableFieldType($this->getColumnName($column));

                }

                $this->addProperty($name, $type, false, true, true);

                $this->addMethod(
                    StringHelper::toCamel("where_".$name),
                    $this->getModelClass($this->model),
                    array('$value')
                );

            }

        }

    }

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function getColumnName($column)
    {
        return $column->getName();
    }

    /**
     * @param $column
     *
     * @access public
     *
     * @return mixed
     */
    public function getColumnType($column)
    {
        return $this->filterTableFieldType($this->getColumnName($column));
    }

    /**
     * @access public
     *
     * @return mixed
     */
    public function getModelClass()
    {
        return '\Illuminate\Database\Query\Builder|\\'.get_class($this->model);
    }

    /**
     * @param $type
     *
     * @access public
     *
     * @return mixed
     */
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

    /**
     * @param        $name
     * @param string $type
     * @param array  $arguments
     *
     * @access public
     *
     * @return mixed
     */
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
