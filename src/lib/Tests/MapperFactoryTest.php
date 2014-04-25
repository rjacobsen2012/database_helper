<?php namespace Tests;

use Drivers\Database\DatabaseService;
use Drivers\Laravel\LaravelService;
use Factories\MapperFactory;
use \Mockery;

class MapperFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testBuildDatabasePasses()
    {

        $args = [
            'mysql',
            '192.168.2.10',
            'root',
            'telecom1',
            'shared_components',
            '1234',
            'socket'
        ];

        $mock = Mockery::mock('Helpers\ConfigHelper');
        $mock->shouldReceive('setConfig')->once()->withArgs([
            $args[0],
            $args[1],
            $args[2],
            $args[3],
            $args[4],
            $args[5],
            $args[6]
        ]);
        $mock->shouldReceive('getType')->once()->andReturn($args[0]);
        $mock->shouldReceive('getHost')->once()->andReturn($args[1]);
        $mock->shouldReceive('getUser')->once()->andReturn($args[2]);
        $mock->shouldReceive('getPassword')->once()->andReturn($args[3]);
        $mock->shouldReceive('getDatabase')->once()->andReturn($args[4]);
        $mock->shouldReceive('getPort')->once()->andReturn($args[5]);
        $mock->shouldReceive('getSocket')->once()->andReturn($args[6]);

        $mock->setConfig(
            $args[0],
            $args[1],
            $args[2],
            $args[3],
            $args[4],
            $args[5],
            $args[6]
        );

        /** \Helpers\ConfigHelper $config */
        $config = $mock;

        $factory = new MapperFactory('User', $config);

        $driver = $factory->build();
        $this->assertTrue($driver instanceof DatabaseService);

    }

    public function testBuildDatabaseFails()
    {

        $args = [
            'postgres',
            '192.168.2.10',
            'root',
            'telecom1',
            'shared_components',
            '1234',
            'socket'
        ];

        $mock = Mockery::mock('Helpers\ConfigHelper');
        $mock->shouldReceive('setConfig')->once()->withArgs([
            $args[0],
            $args[1],
            $args[2],
            $args[3],
            $args[4],
            $args[5],
            $args[6]
        ]);
        $mock->shouldReceive('getType')->once()->andReturn($args[0]);
        $mock->shouldReceive('getHost')->once()->andReturn($args[1]);
        $mock->shouldReceive('getUser')->once()->andReturn($args[2]);
        $mock->shouldReceive('getPassword')->once()->andReturn($args[3]);
        $mock->shouldReceive('getDatabase')->once()->andReturn($args[4]);
        $mock->shouldReceive('getPort')->once()->andReturn($args[5]);
        $mock->shouldReceive('getSocket')->once()->andReturn($args[6]);

        $mock->setConfig(
            $args[0],
            $args[1],
            $args[2],
            $args[3],
            $args[4],
            $args[5],
            $args[6]
        );

        /** \Helpers\ConfigHelper $config */
        $config = $mock;

        $factory = new MapperFactory('User', $config);

        $driver = $factory->build();
        $this->assertFalse($driver instanceof DatabaseService);

        $this->assertFalse($factory->getDatabaseService());

    }

    public function testBuildLaravel()
    {

        $factory = new MapperFactory('Tests\fixtures\UserFixture');

        $driver = $factory->build();
        $this->assertTrue($driver instanceof LaravelService);

    }

}