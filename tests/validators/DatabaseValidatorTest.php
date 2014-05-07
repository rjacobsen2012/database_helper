<?php namespace validators;

use Drivers\Database\DatabaseService;
use Helpers\DatabaseHelper;
use Helpers\MysqlHelper;
use Drivers\Database\Mysql\MysqlRepository;
use Helpers\ConfigHelper;
use \Mockery;

class DatabaseValidatorTest extends \PHPUnit_Framework_TestCase
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumns')
            ->withAnyArgs()
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTable')
            ->withAnyArgs()
            ->once()
            ->andReturn('users');

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTable')
            ->withAnyArgs()
            ->once()
            ->andReturn(null);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);

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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getSchema')
            ->withAnyArgs()
            ->once()
            ->andReturn('newdb');

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );

        $databaseService = $this->getMock(
            'Drivers\Database\DatabaseService',
            [
                'getProperties'
            ],
            [
                'User',
                new DatabaseHelper(),
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
                new MysqlHelper()
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
                'getColumnRequired'
            ],
            [
                'User',
                new MysqlHelper(),
                $mysqlRepo
            ]
        );
        $databaseService->expects($this->any())->method('addProperty')->withAnyParameters()->willReturn([]);
        $databaseService->expects($this->any())->method('getColumnName')->withAnyParameters()->willReturn([]);
        $databaseService->expects($this->any())->method('getColumnType')->withAnyParameters()->willReturn([]);
        $databaseService->expects($this->any())->method('getColumnRequired')->withAnyParameters()->willReturn([]);
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumnName')
            ->with($column)
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('validateDbConnection')
            ->withAnyArgs()
            ->once()
            ->andReturn(false);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getColumnType')
            ->with($column)
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getRequired')
            ->with($column)
            ->once()
            ->andReturn($expected);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
        $actual = $databaseService->getColumnRequired($column);
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
                new MysqlHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
        $databaseService->setProperty('user');
        $databaseService->setPropertyRead('user', true);
        $actual = $databaseService->getPropertyRead('user');
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
                new MysqlHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
        $databaseService->setProperty('user');
        $databaseService->setPropertyWrite('user', true);
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

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
        $databaseService->setProperty('user');
        $databaseService->setPropertyRequired('user', false);
        $actual = $databaseService->getPropertyRequired('user');
        $this->assertEquals($expected, $actual);

    }

    public function testGetModelTable()
    {

        $mysqlRepo = Mockery::mock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                $this->mysqli,
                $this->config,
                new MysqlHelper()
            ]
        );
        $mysqlRepo->shouldReceive('getTable')
            ->withAnyArgs()
            ->once()
            ->andReturn('users');

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
        $databaseService->setTable();
        $table = $databaseService->getModelTable();
        $this->assertEquals('users', $table);

    }

    public function testGetTableSchemaManager()
    {

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
            ->andReturn(null);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
        $this->assertNull($databaseService->getTableSchemaManager());

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

        $databaseService = $this->getMock(
            'Drivers\Database\DatabaseService',
            [
                'getColumns'
            ],
            [
                'User',
                new MysqlHelper(),
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
                new MysqlHelper()
            ]
        );
        $mysqlRepo->expects($this->any())
            ->method('getModelDates')
            ->withAnyParameters()
            ->willReturn(null);

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
            ]
        );

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
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
                new MysqlHelper()
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

        $databaseService = new DatabaseService('User', new MysqlHelper(), $mysqlRepo);
        $databaseService->setTable();
        $databaseService->setSchema();
        $databaseService->setColumns();


        $databaseService = $this->getMock(
            'Drivers\Database\DatabaseService',
            [
                'getColumnName',
                'getColumnType',
                'getColumnRequired'
            ],
            [
                'User',
                new MysqlHelper(),
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
            ->method('getColumnRequired')
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
            ->method('getColumnRequired')
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
            ->method('getColumnRequired')
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
            ->method('getColumnRequired')
            ->withAnyParameters()
            ->willReturn(true);

        $databaseService->setDefaults();

    }

}