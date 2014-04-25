<?php namespace Helpers;

use Doctrine\Common\Inflector\Inflector;

class MapperHelper
{

    public static function getPlural($name)
    {

        return Inflector::pluralize($name);

    }

}