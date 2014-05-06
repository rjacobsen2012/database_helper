<?php namespace Tests;

use Contracts\ModelLoaderInterface;
use Drivers\Database\DatabaseService;
use Drivers\Laravel\LaravelService;
use Factories\MapperFactory;
use Loaders\ModelLoader;
use \Mockery;

class MapperFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testSetGetModelLoader()
    {

        $mapperFactory = new MapperFactory('User');
        $mapperFactory->setModelLoader(new ModelLoader());
        $modelLoader = $mapperFactory->getModelLoader();
        $this->assertTrue($modelLoader instanceof ModelLoader);

    }

    public function testSetGetRepository()
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

        $mapperFactory = new MapperFactory('User', $config);
        $mapperFactory->setRepository();
        $repository = $mapperFactory->getRepository();
        $this->assertEquals($args[0], $repository);

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

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['checkFrameworks'],
            ['User', $config]
        );

        $mapperFactory->expects($this->any())
            ->method('checkFrameworks')
            ->withAnyParameters()
            ->willReturn(false);

        $service = $mapperFactory->build();
        $this->assertTrue($service instanceof DatabaseService);

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

        $mapperFactory = new MapperFactory('Tests\fixtures\UserFixture');

        $driver = $mapperFactory->build();
        $this->assertTrue($driver instanceof LaravelService);

    }

    public function testBuildFails()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['checkFrameworks'],
            ['Tests\fixtures\UserFixture']
        );
        $mapperFactory->expects($this->any())
            ->method('checkFrameworks')
            ->withAnyParameters()
            ->willReturn('codeigniter');

        $driver = $mapperFactory->build();
        $this->assertFalse($driver);

        $error = $mapperFactory->getError();
        $this->assertEquals(
            $error,
            "The mapper was not able to find a valid model or database to get fields from."
        );

    }

    public function testGetDatabaseServicePasses()
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

        $mapperFactory = new MapperFactory('User', $config);
        $mapperFactory->setRepository();
        $service = $mapperFactory->getDatabaseService();
        $this->assertTrue($service instanceof DatabaseService);

    }

    public function testGetDatabaseServiceFails()
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

        $mapperFactory = new MapperFactory('User', $config);
        $mapperFactory->setRepository();
        $service = $mapperFactory->getDatabaseService();
        $this->assertFalse($service);

    }

    public function testIsValidRepository()
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

        $mapperFactory = new MapperFactory('User', $config);
        $mapperFactory->setRepository();
        $this->assertTrue($mapperFactory->isValidRepository());

    }

    public function testIsValidRepositoryFails()
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

        $mapperFactory = new MapperFactory('User', $config);
        $mapperFactory->setRepository();
        $this->assertFalse($mapperFactory->isValidRepository());

    }

    public function testIsValidModel()
    {

        $mapperFactory = new MapperFactory('Tests\fixtures\UserFixture');
        $this->assertEquals('laravel', $mapperFactory->isValidModel());

    }

    public function testIsValidModelFails()
    {

        $mapperFactory = new MapperFactory('User');
        $this->assertFalse($mapperFactory->isValidModel());
        $error = $mapperFactory->getError();
        $this->assertEquals(
            'The field mapper does not recognize the model framework.',
            $error
        );

    }

    public function testCheckFramework()
    {

        $mapperFactory = new MapperFactory('Tests\fixtures\UserFixture');
        $this->assertTrue($mapperFactory->checkFramework('laravel'));

    }

    public function testCheckFrameworkFails()
    {

        $mapperFactory = new MapperFactory('User');
        $this->assertFalse($mapperFactory->checkFramework('codeigniter'));
        $error = $mapperFactory->getError();
        $this->assertEquals(
            'The field mapper does not recognize the model framework.',
            $error
        );

    }

    public function testGetError()
    {

        $mapperFactory = new MapperFactory('User');
        $this->assertFalse($mapperFactory->checkFramework('codeigniter'));
        $error = $mapperFactory->getError();
        $this->assertEquals(
            'The field mapper does not recognize the model framework.',
            $error
        );

    }

}