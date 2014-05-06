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

    public function testTestDbConnectionFailedWithError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->testDbConnection();
        $this->assertEquals('some error', $result->getError());

    }

    public function testTestDbConnectionFailedWithNoError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->testDbConnection('User');
        $this->assertEquals(
            'An unknown error occured while trying to test the database connection.',
            $result->getError()
        );

    }

    public function testTestDbConnectionSucceeded()
    {

        $responseHandler = new ResponseHandler();

        $mapperFactory = $this->getMock(
            'Factories\MapperFactory',
            ['build', 'setDefaults', 'testDbConnectionFails'],
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
            ->method('testDbConnectionFails')
            ->withAnyParameters()
            ->willReturn([]);

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->testDbConnection('User');
        $this->assertTrue($result->getSuccess());

        $this->assertEquals([], $result->getResult());

    }

    public function testTestModelFailedWithError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->testModel('User');
        $this->assertEquals('some error', $result->getError());

    }

    public function testTestModelFailedWithNoError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->testModel('User');
        $this->assertEquals(
            'An unknown error occured while trying to load the model.',
            $result->getError()
        );

    }

    public function testTestModelSucceeded()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->testModel('User');
        $this->assertTrue($result->getSuccess());

    }

    public function testGetFieldsFailedWithError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->getFields('User');
        $this->assertEquals('some error', $result->getError());

    }

    public function testGetFieldsFailedWithNoError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->getFields('User');
        $this->assertEquals(
            'An unknown error occured while trying to retrieve the fields.',
            $result->getError()
        );

    }

    public function testGetFieldsSucceeded()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->getFields('User');
        $this->assertTrue($result->getSuccess());
        $this->assertEquals([], $result->getResult());

    }

    public function testGetInfoFailedWithError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->getInfo('User');
        $this->assertEquals('some error', $result->getError());

    }

    public function testGetInfoFailedWithNoError()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->getInfo('User');
        $this->assertEquals(
            'An unknown error occured while trying to retrieve the model or database info.',
            $result->getError()
        );

    }

    public function testGetInfoSucceeded()
    {

        $responseHandler = new ResponseHandler();

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

        $mapper->setResponseHandler($responseHandler);
        $setResponseHandler = $mapper->getResponseHandler();
        $this->assertTrue($setResponseHandler instanceof ResponseHandler);
        $result = $mapper->getInfo('User');
        $this->assertTrue($result->getSuccess());
        $this->assertEquals([], $result->getResult());

    }

}
