<?php namespace helpers;

use Helpers\StringHelper;
use \Mockery;

class StringHelperTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testToLower()
    {

        $string = 'Users';
        $expected = 'users';
        $actual = StringHelper::toLower($string);
        $this->assertEquals($expected, $actual);

    }

    public function testToCamel()
    {

        $string = 'where_users';
        $expected = 'whereUsers';
        $actual = StringHelper::toCamel($string);
        $this->assertEquals($expected, $actual);

    }

    public function testExplodeString()
    {

        $testString = "/www/folder/User";
        $exploded = StringHelper::explodeString($testString, "/");
        $this->assertEquals(['','www','folder','User'], $exploded);

    }

}
