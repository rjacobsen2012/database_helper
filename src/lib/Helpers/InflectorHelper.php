<?php namespace Helpers;

use Doctrine\Common\Inflector\Inflector;

class InflectorHelper
{

    public static function getPlural($name)
    {

        return Inflector::pluralize($name);

    }

}