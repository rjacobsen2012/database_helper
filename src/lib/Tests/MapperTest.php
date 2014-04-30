<?php namespace Tests;

use \Mockery;

class MapperTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testSetGetConfig()
    {

        $expected = [
            'type' => 'mysql',
            'host' => '123.45.567.8',
            'user' => 'someuser',
            'password' => '1234',
            'database' => 'newdb',
            'port' => 'someport',
            'socket' => 'somesocket'
        ];

        $mapper = new \Mapper();
        $mapper->setDbConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $this->assertEquals($expected, $mapper->getDbConfig());

    }

    public function testGetFields()
    {

        $expected = [
            'type' => 'mysql',
            'host' => '123.45.567.8',
            'user' => 'someuser',
            'password' => '1234',
            'database' => 'newdb',
            'port' => 'someport',
            'socket' => 'somesocket'
        ];

        $mapper = new \Mapper();
        $mapper->setDbConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $properties = $mapper->getFields('User');
        $this->assertEquals([], $properties);

    }

    public function testGetInfo()
    {

        $expected = [
            'type' => 'mysql',
            'host' => '123.45.567.8',
            'user' => 'someuser',
            'password' => '1234',
            'database' => 'newdb',
            'port' => 'someport',
            'socket' => 'somesocket'
        ];

        $mapper = new \Mapper();
        $mapper->setDbConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $info = $mapper->getInfo('User');
        $this->assertEquals(['properties' => []], $info);

    }

}
