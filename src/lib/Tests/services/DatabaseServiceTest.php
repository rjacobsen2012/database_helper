<?php namespace Tests\services;

use Drivers\Database\DatabaseService;
use Drivers\Database\Mysql\MysqlHelper;
use Drivers\Database\Mysql\MysqlRepository;
use Helpers\ConfigHelper;
use \Mockery;

class DatabaseServiceTest extends \PHPUnit_Framework_TestCase
{

    protected $config;

    protected $mysqli;

    public function setUp()
    {

        parent::setUp();
        $this->setConfig();
        $this->setMysql();

    }

    protected function setConfig()
    {

        $this->config = Mockery::mock('Helpers\ConfigHelper');
        $this->config->shouldReceive('setConfig')->withArgs(
            [
                'mysql',
                '123.45.567.8',
                'someuser',
                '1234',
                'newdb',
                'someport',
                'somesocket'
            ]
        );

    }

    protected function setMysql()
    {

        $this->mysqli = Mockery::mock('\mysqli');

    }

    public function testGetTableColumns()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTableColumns')
            ->withAnyArgs()
            ->once()
            ->andReturn($this->mysqli);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $columns = $databaseService->getTableColumns();
        $this->assertTrue($columns instanceof $this->mysqli);

    }

    public function testGetModelTableInfo()
    {

        $expected = [
            'properties' => [
                'id' => [
                    'type' => 'integer',
                    'read' => true,
                    'write' => true,
                    'required' => true
                ],
                'name' => [
                    'type' => 'string',
                    'read' => true,
                    'write' => true,
                    'required' => false
                ],
                'created_at' => [
                    'type' => '\Carbon\Carbon',
                    'read' => true,
                    'write' => true,
                    'required' => false
                ]
            ]
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getModelTableInfo')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getModelTableInfo();
        $this->assertEquals($expected, $actual);

    }

    public function testGetTableProperties()
    {

        $expected = [
            'id' => [
                'type' => 'integer',
                'read' => true,
                'write' => true,
                'required' => true
            ],
            'name' => [
                'type' => 'string',
                'read' => true,
                'write' => true,
                'required' => false
            ],
            'created_at' => [
                'type' => '\Carbon\Carbon',
                'read' => true,
                'write' => true,
                'required' => false
            ]
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTableProperties')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getTableProperties();
        $this->assertEquals($expected, $actual);

    }

    public function testGetModelTable()
    {

        $expected = 'user';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getModelTable')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getModelTable();
        $this->assertEquals($expected, $actual);

    }

    public function testGetTableSchemaManager()
    {

        $expected = null;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTableSchemaManager')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getTableSchemaManager();
        $this->assertEquals($expected, $actual);

    }

    public function testGetModelDates()
    {

        $expected = [
            'created_at'
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getModelDates')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getModelDates();
        $this->assertEquals($expected, $actual);

    }

    public function testFilterTableColumns()
    {

        $expected = [];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('filterTableColumns')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->filterTableColumns();
        $this->assertEquals($expected, $actual);

    }

    public function testGetColumnName()
    {

        $expected = [];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumnName')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getColumnName('user');
        $this->assertEquals($expected, $actual);

    }

    public function testGetColumnType()
    {

        $expected = 'string';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumnType')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getColumnType('user');
        $this->assertEquals($expected, $actual);

    }

    public function testFilterTableFieldType()
    {

        $expected = 'string';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('filterTableFieldType')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->filterTableFieldType('user');
        $this->assertEquals($expected, $actual);

    }

    public function testAddProperty()
    {

        $expected = 'string';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('addProperty')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->addProperty('user', 'string');
        $this->assertEquals($expected, $actual);

    }

    public function testSetProperty()
    {

        $expected = [];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('setProperty')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->setProperty('user');
        $this->assertEquals($expected, $actual);

    }

    public function testGetProperty()
    {

        $expected = [];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getProperty')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getProperty('user');
        $this->assertEquals($expected, $actual);

    }

    public function testSetPropertyType()
    {

        $expected = 'string';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('setPropertyType')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->setPropertyType('user', 'string');
        $this->assertEquals($expected, $actual);

    }

    public function testGetPropertyType()
    {

        $expected = 'string';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getPropertyType')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getPropertyType('user');
        $this->assertEquals($expected, $actual);

    }

    public function testSetPropertyRead()
    {

        $expected = true;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('setPropertyRead')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->setPropertyRead('user', true);
        $this->assertEquals($expected, $actual);

    }

    public function testGetPropertyRead()
    {

        $expected = true;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getPropertyRead')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getPropertyRead('user');
        $this->assertEquals($expected, $actual);

    }

    public function testSetPropertyWrite()
    {

        $expected = true;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('setPropertyWrite')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->setPropertyWrite('user', true);
        $this->assertEquals($expected, $actual);

    }

    public function testGetPropertyWrite()
    {

        $expected = true;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getPropertyWrite')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getPropertyWrite('user');
        $this->assertEquals($expected, $actual);

    }

    public function testSetPropertyRequired()
    {

        $expected = false;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('setPropertyRequired')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->setPropertyRequired('user', false);
        $this->assertEquals($expected, $actual);

    }

    public function testGetPropertyRequired()
    {

        $expected = false;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getPropertyRequired')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', $mysqlRepo);
        $actual = $databaseService->getPropertyRequired('user');
        $this->assertEquals($expected, $actual);

    }

}