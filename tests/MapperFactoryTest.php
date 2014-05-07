<?php namespace tests;

use Contracts\ModelLoaderInterface;
use Drivers\Database\DatabaseService;
use Drivers\Laravel\LaravelService;
use Factories\MapperFactory;
use Helpers\MysqlHelper;
use Loaders\ModelLoader;
use \Mockery;

class MapperFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testBuildDatabase()
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

        $modelValidator = Mockery::mock('Validators\ModelValidator');
        $modelValidator->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn(false);

        $databaseService = Mockery::mock('Drivers\Database\DatabaseService');

        $databaseValidator = Mockery::mock('Validators\DatabaseValidator');
        $databaseValidator->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn($databaseService);

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['getModelValidator', 'getDatabaseValidator'],
            ['User', $config]
        );

        $mapperFactory->expects($this->any())
            ->method('getModelValidator')
            ->withAnyParameters()
            ->willReturn($modelValidator);

        $mapperFactory->expects($this->any())
            ->method('getDatabaseValidator')
            ->withAnyParameters()
            ->willReturn($databaseValidator);

        $service = $mapperFactory->build();
        $this->assertTrue($service instanceof DatabaseService);

    }

    public function testBuildLaravel()
    {

        $mapperFactory = new MapperFactory('/www/field-dresser/tests/fixtures/UserFixture');

        $driver = $mapperFactory->build();
        $this->assertTrue($driver instanceof LaravelService);

    }

    public function testBuildFails()
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

        $modelValidator = Mockery::mock('Validators\ModelValidator');
        $modelValidator->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn(false);

        $databaseValidator = Mockery::mock('Validators\DatabaseValidator');
        $databaseValidator->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn(false);

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['getModelValidator', 'getDatabaseValidator'],
            ['User', $config]
        );

        $mapperFactory->expects($this->any())
            ->method('getModelValidator')
            ->withAnyParameters()
            ->willReturn($modelValidator);

        $mapperFactory->expects($this->any())
            ->method('getDatabaseValidator')
            ->withAnyParameters()
            ->willReturn($databaseValidator);

        $service = $mapperFactory->build();
        $this->assertFalse($service);

        $error = $mapperFactory->getError();
        $this->assertEquals(
            $error,
            "The mapper was not able to find a valid model or database to get fields from."
        );

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
        $repository = $mapperFactory->isValidRepository();
        $this->assertTrue($repository instanceof DatabaseService);

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
        $respository = $mapperFactory->isValidRepository();
        $this->assertFalse($respository);

    }

    public function testIsValidModel()
    {

        $mapperFactory = new MapperFactory('/www/field-dresser/tests/fixtures/UserFixture');
        $model = $mapperFactory->isValidModel();
        $this->assertTrue($model instanceof LaravelService);

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

}