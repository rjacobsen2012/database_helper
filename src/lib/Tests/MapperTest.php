<?php namespace Tests;

use Drivers\Database\DatabaseService;
use Factories\MapperFactory;
use Helpers\ConfigHelper;
use Helpers\MysqlHelper;
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

    public function testTestDbConnection()
    {

        $config = new ConfigHelper();

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory', 'build']
        );

        $mapperFactory = $this->getMock(
            '\Factories\MapperFactory',
            ['build'],
            [
                null,
                $config
            ]
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mysqli = Mockery::mock('\mysqli');

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );

        $databaseService = $this->getMock(
            '\Drivers\Database\DatabaseService',
            ['testDbConnectionFails'],
            [
                null,
                new MysqlHelper(),
                $mysqlRepo
            ]
        );

        $databaseService->expects($this->any())
            ->method('testDbConnectionFails')
            ->withAnyParameters()
            ->willReturn(true);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn($databaseService);

        $this->assertTrue($mapper->testDbConnection());

    }

    public function testGetFields()
    {

        $config = new ConfigHelper();

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory', 'build']
        );

        $mapperFactory = $this->getMock(
            '\Factories\MapperFactory',
            ['build'],
            [
                null,
                $config
            ]
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mysqli = Mockery::mock('\mysqli');

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );

        $databaseService = $this->getMock(
            '\Drivers\Database\DatabaseService',
            ['setDefaults', 'getTableProperties'],
            [
                null,
                new MysqlHelper(),
                $mysqlRepo
            ]
        );

        $databaseService->expects($this->any())
            ->method('setDefaults')
            ->withAnyParameters()
            ->willReturn($databaseService);

        $databaseService->expects($this->any())
            ->method('getTableProperties')
            ->withAnyParameters()
            ->willReturn([]);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn($databaseService);

        $this->assertEquals([], $mapper->getFields(null));

    }

    public function testGetInfo()
    {

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
        $this->assertEquals(['properties' => null], $info);

    }

}
