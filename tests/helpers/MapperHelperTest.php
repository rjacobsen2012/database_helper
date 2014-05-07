<?php namespace helpers;

use Helpers\MapperHelper;
use \Mockery;

class MapperHelperTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testBuild()
    {

        $this->assertEquals('Users', MapperHelper::getPlural('User'));

    }

}