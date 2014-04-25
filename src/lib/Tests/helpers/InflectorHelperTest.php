<?php namespace Tests;

use Helpers\InflectorHelper;
use \Mockery;

class InflectorHelperTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testGetPlural()
    {

        $string = 'User';
        $expected = 'Users';
        $actual = InflectorHelper::getPlural($string);
        $this->assertEquals($expected, $actual);

    }

}
