<?php namespace validators;

use Drivers\Database\DatabaseService;
use \Mockery;

class DatabaseValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testValidatePasses()
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

        $mock = Mockery::mock('Drivers\Database\DatabaseConfig');
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

        /** \Drivers\Database\DatabaseConfig $config */
        $config = $mock;

        $databaseValidator = new DatabaseValidator();

        $connection = $databaseValidator->validate(
            'User',
            $config
        );

        $this->assertTrue($connection instanceof DatabaseService);

    }

    public function testValidateFails()
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

        $mock = Mockery::mock('Drivers\Database\DatabaseConfig');
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

        /** \Drivers\Database\DatabaseConfig $config */
        $config = $mock;

        $databaseValidator = new DatabaseValidator();

        $connection = $databaseValidator->validate(
            'User',
            $config
        );

        $this->assertNull($connection);

    }

    public function testValidateFailsWithInvalidType()
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

        $mock = Mockery::mock('Drivers\Database\DatabaseConfig');
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

        /** \Drivers\Database\DatabaseConfig $config */
        $config = $mock;

        $databaseValidator = $this->getMock(
            'Validators\DatabaseValidator',
            ['isValidRepository']
        );

        $databaseValidator->expects($this->any())
            ->method('isValidRepository')
            ->withAnyParameters()
            ->willReturn(true);

        $valid = $databaseValidator->validate('User', $config);
        $this->assertNull($valid);

    }

    public function testIsValidRepositorySuccess()
    {

        $databaseValidator = new DatabaseValidator();

        $valid = $databaseValidator->isValidRepository('mysql');
        $this->assertTrue($valid);

    }

    public function testIsValidRepositoryFails()
    {

        $databaseValidator = new DatabaseValidator();

        $valid = $databaseValidator->isValidRepository('postgres');
        $this->assertFalse($valid);

    }

}