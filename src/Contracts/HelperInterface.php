<?php namespace Contracts;

/**
 * Interface HelperInterface
 *
 * @package Contracts
 */
interface HelperInterface
{

    /**
     * @param $type
     *
     * @return boolean
     */
    public function isString($type);

    /**
     * @param $type
     *
     * @return boolean
     */
    public function isInteger($type);

    /**
     * @param $type
     *
     * @return boolean
     */
    public function isDecimal($type);

    /**
     * @param $type
     *
     * @return boolean
     */
    public function isBoolean($type);

    /**
     * @param $type
     *
     * @return boolean
     */
    public function isMixed($type);

    /**
     * @param $type
     *
     * @return string
     */
    public function filterTableFieldType($type);

}