<?php namespace Contracts;

interface HelperInterface
{

    public function isString($type);

    public function isInteger($type);

    public function isDecimal($type);

    public function isBoolean($type);

    public function isMixed($type);

}