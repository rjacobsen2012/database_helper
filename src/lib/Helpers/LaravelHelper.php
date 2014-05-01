<?php namespace Helpers;

use Contracts\HelperInterface;

class LaravelHelper implements HelperInterface
{

    public function isString($type)
    {

        if (strpos($type, 'varchar') !== false ||
            strpos($type, 'string') !== false ||
            strpos($type, 'text') !== false ||
            strpos($type, 'date') !== false ||
            strpos($type, 'time') !== false ||
            strpos($type, 'guid') !== false ||
            strpos($type, 'datetimetz') !== false ||
            strpos($type, 'datetime') !== false) {

            return true;

        }

        return false;

    }

    public function isInteger($type)
    {

        if (strpos($type, 'int') !== false ||
            strpos($type, 'integer') !== false ||
            strpos($type, 'bigint') !== false ||
            strpos($type, 'smallint') !== false) {

            return true;

        }

        return false;

    }

    public function isDecimal($type)
    {

        if (strpos($type, 'decimal') !== false ||
            strpos($type, 'float') !== false) {

            return true;

        }

        return false;

    }

    public function isBoolean($type)
    {

        if (strpos($type, 'boolean') !== false) {

            return true;

        }

        return false;

    }

    public function isMixed($type)
    {

        if (strpos($type, 'mixed') !== false) {

            return true;

        }

        return false;

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

            case $this->isString($type):

                return 'string';

                break;

            case $this->isInteger($type):

                return 'integer';

                break;

            case $this->isDecimal($type):

                return 'float';

                break;

            case $this->isBoolean($type):

                return 'boolean';

                break;

            case $this->isMixed($type):

                return 'mixed';

                break;

            default:

                return '';

        }
    }

}