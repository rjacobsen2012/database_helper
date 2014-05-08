<?php namespace services;

use Drivers\Database\DatabaseService;
use Helpers\ServiceHelper;
use Drivers\Database\Mysql\MysqlRepository;
use Drivers\Database\DatabaseConfig;
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

        $this->config = Mockery::mock('Drivers\Database\DatabaseConfig');
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

    public function testSetGetTableColumns()
    {

        $expected = [
            'id' => [
                'Field' => 'id',
                'Type' => 'integer',
                'Null' => 'NO'
            ],
            'name' => [
                'Field' => 'name',
                'Type' => 'varchar(45)',
                'Null' => 'NO'
            ],
            'subdomain' => [
                'Field' => 'subdomain',
                'Type' => 'varchar(25)',
                'Null' => 'YES'
            ],
            'created_at' => [
                'Field' => 'created_at',
                'Type' => 'timestamp',
                'Null' => 'NO'
            ]
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumns')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setColumns();
        $columns = $databaseService->getColumns();
        $this->assertEquals($expected, $columns);

    }

    public function testSetGetTablePasses()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTable')
            ->withAnyArgs()
            ->once()
            ->andReturn('users');

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setTable();
        $table = $databaseService->getTable();
        $this->assertEquals('users', $table);

    }

    public function testSetTableFails()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTable')
            ->withAnyArgs()
            ->once()
            ->andReturn(null);

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);

        $this->setExpectedException('Exception');

        $e = null;

        try {

            $table = $databaseService->setTable();

        } catch (Mockery\Exception $e) {



        }

        $this->assertTrue($e instanceof Mockery\Exception, "Method getResponse should have thrown an exception");

    }

    public function testSetGetSchema()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getSchema')
            ->withAnyArgs()
            ->once()
            ->andReturn('newdb');

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setSchema();
        $schema = $databaseService->getSchema();
        $this->assertEquals('newdb', $schema);

    }

    public function testGetTableProperties()
    {

        $mysqlRepository = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = $this->getMock(
            'Drivers\Database\DatabaseService',
            [
                'getProperties'
            ],
            [
                'User',
                new ServiceHelper(),
                $mysqlRepository
            ]
        );

        $databaseService->expects($this->any())
            ->method('getProperties')
            ->willReturn([]);
        $properties = $databaseService->getTableProperties();
        $this->assertEquals([], $properties);

    }

    public function testFilterTableColumns()
    {

        $expected = [
            'id' => [
                'Field' => 'id',
                'Type' => 'integer',
                'Null' => 'NO'
            ],
            'name' => [
                'Field' => 'name',
                'Type' => 'varchar(45)',
                'Null' => 'NO'
            ],
            'subdomain' => [
                'Field' => 'subdomain',
                'Type' => 'varchar(25)',
                'Null' => 'YES'
            ],
            'created_at' => [
                'Field' => 'created_at',
                'Type' => 'timestamp',
                'Null' => 'NO'
            ]
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumns')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = $this->getMock(
            'Drivers\Database\DatabaseService',
            [
                'addProperty',
                'getColumnName',
                'getColumnType',
                'isColumnRequired'
            ],
            [
                'User',
                new ServiceHelper(),
                $mysqlRepo
            ]
        );
        $databaseService->expects($this->any())->method('addProperty')->withAnyParameters()->willReturn([]);
        $databaseService->expects($this->any())->method('getColumnName')->withAnyParameters()->willReturn([]);
        $databaseService->expects($this->any())->method('getColumnType')->withAnyParameters()->willReturn([]);
        $databaseService->expects($this->any())->method('isColumnRequired')->withAnyParameters()->willReturn([]);
        $databaseService->setColumns();
        $databaseService->filterTableColumns();

    }

    public function testGetColumnName()
    {

        $column = [
            'Field' => 'subdomain'
        ];

        $expected = 'subdomain';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumnName')
            ->with($column)
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $actual = $databaseService->getColumnName($column);
        $this->assertEquals($expected, $actual);

    }

    public function testValidateDbConnectionFails()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('validateDbConnection')
            ->withAnyArgs()
            ->once()
            ->andReturn(false);

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $this->assertFalse($databaseService->validateDbConnection());

    }

    public function testGetColumnType()
    {

        $column = [
            'Type' => 'varchar(45)'
        ];

        $expected = 'string';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumnType')
            ->with($column)
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $actual = $databaseService->getColumnType($column);
        $this->assertEquals($expected, $actual);

    }

    public function testGetColumnRequired()
    {

        $column = [
            'Null' => 'NO'
        ];

        $expected = true;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('isRequired')
            ->with($column)
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $actual = $databaseService->isColumnRequired($column);
        $this->assertEquals($expected, $actual);

    }

    public function testAddProperty()
    {

        $name = 'subdomain';
        $type = 'string';
        $required = false;
        $read = true;
        $write = true;

        $expected = [
            'type' => 'string',
            'required' => false,
            'read' => true,
            'write' => true
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->addProperty(
            $name,
            $type,
            $required,
            $read,
            $write
        );
        $this->assertEquals($expected, $databaseService->getProperty($name));

    }

    public function testSetGetProperty()
    {

        $name = 'subdomain';

        $expected = [];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setProperty($name);
        $actual = $databaseService->getProperty($name);
        $this->assertEquals($expected, $actual);

    }

    public function testSetGetPropertyType()
    {

        $expected = 'string';

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setProperty('user');
        $databaseService->setPropertyType('user', 'string');
        $actual = $databaseService->getPropertyType('user');
        $this->assertEquals($expected, $actual);

    }

    public function testSetGetPropertyRead()
    {

        $expected = true;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setProperty('user');
        $databaseService->setPropertyRead('user', true);
        $actual = $databaseService->isPropertyRead('user');
        $this->assertEquals($expected, $actual);

    }

    public function testSetGetPropertyWrite()
    {

        $expected = true;

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setProperty('user');
        $databaseService->setPropertyWrite('user', true);
        $actual = $databaseService->isPropertyWrite('user');
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
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setProperty('user');
        $databaseService->setPropertyRequired('user', false);
        $actual = $databaseService->isPropertyRequired('user');
        $this->assertEquals($expected, $actual);

    }

    public function testGetModelTable()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTable')
            ->withAnyArgs()
            ->once()
            ->andReturn('users');

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setTable();
        $table = $databaseService->getModelTable();
        $this->assertEquals('users', $table);

    }

    public function testGetTableColumns()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = $this->getMock(
            'Drivers\Database\DatabaseService',
            [
                'getColumns'
            ],
            [
                'User',
                new ServiceHelper(),
                $mysqlRepo
            ]
        );
        $databaseService->expects($this->any())
            ->method('getColumns')
            ->withAnyParameters()
            ->willReturn([]);
        $columns = $databaseService->getTableColumns();
        $this->assertEquals([], $columns);

    }

    public function testGetModelDates()
    {

        $mysqlRepo = $this->getMock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                'getModelDates'
            ],
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->expects($this->any())
            ->method('getModelDates')
            ->withAnyParameters()
            ->willReturn(null);

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $this->assertNull($databaseService->getModelDates());

    }

    public function testGetProperties()
    {

        $name = 'subdomain';
        $type = 'string';
        $required = false;
        $read = true;
        $write = true;

        $expected = [
            'subdomain' => [
                'type' => 'string',
                'required' => false,
                'read' => true,
                'write' => true
            ]
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->addProperty(
            $name,
            $type,
            $required,
            $read,
            $write
        );
        $properties = $databaseService->getProperties();
        $this->assertEquals($expected, $properties);

    }

    public function testGetModelTableInfo()
    {

        $name = 'subdomain';
        $type = 'string';
        $required = false;
        $read = true;
        $write = true;

        $expected = [
            'properties' => [
                'subdomain' => [
                    'type' => 'string',
                    'required' => false,
                    'read' => true,
                    'write' => true
                ]
            ]
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->addProperty(
            $name,
            $type,
            $required,
            $read,
            $write
        );
        $properties = $databaseService->getModelTableInfo();
        $this->assertEquals($expected, $properties);

    }

    public function testSetDefaults()
    {

        $columns = [
            'id' => [
                'Field' => 'id',
                'Type' => 'integer',
                'Null' => 'NO'
            ],
            'name' => [
                'Field' => 'name',
                'Type' => 'varchar(45)',
                'Null' => 'NO'
            ],
            'subdomain' => [
                'Field' => 'subdomain',
                'Type' => 'varchar(25)',
                'Null' => 'YES'
            ],
            'created_at' => [
                'Field' => 'created_at',
                'Type' => 'timestamp',
                'Null' => 'NO'
            ]
        ];

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new ServiceHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTable')
            ->withAnyArgs()
            ->once()
            ->andReturn('users');
        $mysqlRepo->shouldReceive('getSchema')
            ->withAnyArgs()
            ->once()
            ->andReturn('newdb');
        $mysqlRepo->shouldReceive('getColumns')
            ->withAnyArgs()
            ->once()
            ->andReturn($columns);
        $mysqlRepo->shouldReceive('setDbConnection')
            ->withAnyArgs()
            ->once();

        $databaseService = new DatabaseService('User', new ServiceHelper(), $mysqlRepo);
        $databaseService->setTable();
        $databaseService->setSchema();
        $databaseService->setColumns();


        $databaseService = $this->getMock(
            'Drivers\Database\DatabaseService',
            [
                'getColumnName',
                'getColumnType',
                'isColumnRequired'
            ],
            [
                'User',
                new ServiceHelper(),
                $mysqlRepo
            ]
        );

        $databaseService->expects($this->at(0))
            ->method('getColumnName')
            ->withAnyParameters()
            ->willReturn('id');
        $databaseService->expects($this->at(0))
            ->method('getColumnType')
            ->withAnyParameters()
            ->willReturn('integer');
        $databaseService->expects($this->at(0))
            ->method('isColumnRequired')
            ->withAnyParameters()
            ->willReturn(true);

        $databaseService->expects($this->at(1))
            ->method('getColumnName')
            ->withAnyParameters()
            ->willReturn('name');
        $databaseService->expects($this->at(1))
            ->method('getColumnType')
            ->withAnyParameters()
            ->willReturn('string');
        $databaseService->expects($this->at(1))
            ->method('isColumnRequired')
            ->withAnyParameters()
            ->willReturn(true);

        $databaseService->expects($this->at(2))
            ->method('getColumnName')
            ->withAnyParameters()
            ->willReturn('subdomain');
        $databaseService->expects($this->at(2))
            ->method('getColumnType')
            ->withAnyParameters()
            ->willReturn('string');
        $databaseService->expects($this->at(2))
            ->method('isColumnRequired')
            ->withAnyParameters()
            ->willReturn(false);

        $databaseService->expects($this->at(3))
            ->method('getColumnName')
            ->withAnyParameters()
            ->willReturn('created_at');
        $databaseService->expects($this->at(3))
            ->method('getColumnType')
            ->withAnyParameters()
            ->willReturn('\Carbon\Carbon');
        $databaseService->expects($this->at(3))
            ->method('isColumnRequired')
            ->withAnyParameters()
            ->willReturn(true);

        $databaseService->setDefaults();

    }

}