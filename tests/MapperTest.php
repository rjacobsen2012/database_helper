<?php namespace Tests;

use Drivers\Database\DatabaseService;
use Factories\MapperFactory;
use Handlers\ResponseHandler;
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

    public function testGetMapperFactory()
    {

        $mapper = new \Mapper();
        $mapperFactory = $mapper->getMapperFactory('User');
        $this->assertTrue($mapperFactory instanceof MapperFactory);

    }

    public function testValidateDbConnectionFailedToFindMapperWithError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn('some error');

        $e = null;

        try {
            $result = $mapper->validateDbConnection();
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testValidateDbConnectionFailedToFindMapperWithoutError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn(null);

        $e = null;

        try {
            $result = $mapper->validateDbConnection();
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testValidateDbConnectionFailed()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $databaseService = Mockery::mock('Drivers\Database\DatabaseService');
        $databaseService->shouldReceive('validateDbConnection')
            ->once()
            ->andReturn(false);

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn($databaseService);

        $e = null;

        try {
            $result = $mapper->validateDbConnection();
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testValidateDbConnectionSucceeded()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'validateDbConnection'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('validateDbConnection')
            ->withAnyParameters()
            ->willReturn(true);

        $this->assertTrue($mapper->validateDbConnection());

    }

    public function testTestModelFailedWithError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['isValidModel', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('isValidModel')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn('some error');

        $e = null;

        try {
            $result = $mapper->validateModel('User');
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testTestModelFailedWithoutError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['isValidModel', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('isValidModel')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn(null);

        $e = null;

        try {
            $result = $mapper->validateModel('User');
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testTestModelSucceeded()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['isValidModel', 'setDefaults', 'getTableProperties'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('isValidModel')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $result = $mapper->validateModel('User');
        $this->assertTrue($result);

    }

    public function testGetFieldsFailedWithError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn('some error');

        $e = null;

        try {
            $result = $mapper->getFields('User');
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testGetFieldsFailedWithoutError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn(null);

        $e = null;

        try {
            $result = $mapper->getFields('User');
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testGetFieldsSucceeded()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'setDefaults', 'getTableProperties'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('setDefaults')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('getTableProperties')
            ->withAnyParameters()
            ->willReturn([]);

        $result = $mapper->getFields('User');
        $this->assertEquals([], $result);

    }

    public function testGetInfoFailedWithError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn('some error');

        $e = null;

        try {
            $result = $mapper->getInfo('User');
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testGetInfoFailedWithoutError()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'getError'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn(false);

        $mapperFactory->expects($this->any())
            ->method('getError')
            ->withAnyParameters()
            ->willReturn(null);

        $e = null;

        try {
            $result = $mapper->getInfo('User');
        } catch (\Exception $e) {

        }

        $this->assertTrue($e instanceof \Exception);

    }

    public function testGetInfoSucceeded()
    {

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'setDefaults', 'getModelTableInfo'],
            ['User']
        );

        $mapper = $this->getMock(
            '\Mapper',
            ['getMapperFactory']
        );

        $mapper->expects($this->any())
            ->method('getMapperFactory')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('build')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('setDefaults')
            ->withAnyParameters()
            ->willReturn($mapperFactory);

        $mapperFactory->expects($this->any())
            ->method('getModelTableInfo')
            ->withAnyParameters()
            ->willReturn([]);

        $result = $mapper->getInfo('User');
        $this->assertEquals([], $result);

    }

}
