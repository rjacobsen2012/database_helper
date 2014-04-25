<?php namespace Helpers;

use Illuminate\Support\Str;

class StringHelper
{

    public static function toLower($string)
    {

        return strtolower($string);

    }

    public static function toCamel($string)
    {

        return Str::camel($string);

    }

}