<?php namespace services;

use Doctrine\DBAL\Schema\MySqlSchemaManager;
use Helpers\ServiceHelper;
use Drivers\Laravel\LaravelService;
use \Mockery;

class LaravelServiceTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testGetModelTable()
    {

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');

        $service = new LaravelService($model, new ServiceHelper());
        $this->assertEquals('companies', $service->getModelTable());

    }

    public function testSetGetTable()
    {

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $service->setTable();

        $this->assertEquals('companies', $service->getTable());

    }

    public function testGetTableSchemaManager()
    {

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $service->setTable();
        $schema = $service->getTableSchemaManager();
        $this->assertTrue($schema instanceof MySqlSchemaManager);

    }

    public function testValidateDbConnectionFails()
    {

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $this->assertFalse($service->validateDbConnection());

    }

    public function testSetGetSchema()
    {

        $column = Mockery::mock('Doctrine\DBAL\Schema\Column');

        $returnArray = [
            'id' => $column,
            'subdomain' => $column,
            'name' => $column
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $service->setTable();
        $service->setSchema();
        $this->assertTrue($service->getSchema() instanceof MySqlSchemaManager);

    }

    public function testGetTableColumns()
    {

        $column = Mockery::mock('Doctrine\DBAL\Schema\Column');

        $returnArray = [
            'id' => $column,
            'subdomain' => $column,
            'name' => $column,
            'created_at' => new \DateTime
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $service->setTable();
        $service->setSchema();
        $service->setColumns();
        $this->assertEquals($returnArray, $service->getColumns());

    }

    public function testGetModelDates()
    {

        $expected = [
            'created_at',
            'updated_at'
        ];

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getDates')->andReturn($expected);

        $service = new LaravelService($model, new ServiceHelper());
        $dates = $service->getModelDates();
        $this->assertEquals($expected, $dates);

    }

    public function testGetColumnName()
    {

        $column = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $column->shouldReceive('getName')->andReturn('name');

        $returnArray = [
            'id' => $column,
            'subdomain' => $column,
            'name' => $column,
            'created_at' => new \DateTime
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $service->setTable();
        $service->setSchema();
        $service->setColumns();

        $columnName = $service->getColumnName($returnArray['name']);
        $this->assertEquals('name', $columnName);

    }

    public function testGetColumnType()
    {

        $type = Mockery::mock('Doctrine\DBAL\Types\StringType');
        $type->shouldReceive('getName')->andReturn('string');

        $column = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $column->shouldReceive('getType')->andReturn($type);

        $returnArray = [
            'name' => $column
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $service->setTable();
        $service->setSchema();
        $service->setColumns();

        foreach ($returnArray as $column) {

            $this->assertEquals('string', $service->getColumnType($column));

        }

    }

    public function testSetGetProperty()
    {

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');

        $service = new LaravelService($model, new ServiceHelper());
        $service->setProperty('name');
        $this->assertFalse(is_null($service->getProperty('name')));
        $this->assertTrue(is_null($service->getProperty('subdomain')));

    }

    public function testSetGetPropertyType()
    {

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');

        $service = new LaravelService($model, new ServiceHelper());
        $service->setProperty('name');
        $service->setPropertyType('name', 'string');
        $this->assertEquals('string', $service->getPropertyType('name'));
        $this->assertTrue(is_null($service->getPropertyType('subdomain')));

    }

    public function testSetGetPropertyRead()
    {

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');

        $service = new LaravelService($model, new ServiceHelper());
        $service->setProperty('name');
        $service->setPropertyRead('name', true);
        $this->assertTrue($service->isPropertyRead('name'));
        $this->assertTrue(is_null($service->isPropertyRead('subdomain')));

    }

    public function testSetGetPropertyWrite()
    {

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');

        $service = new LaravelService($model, new ServiceHelper());
        $service->setProperty('name');
        $service->setPropertyWrite('name', true);
        $this->assertTrue($service->isPropertyWrite('name'));
        $this->assertTrue(is_null($service->isPropertyWrite('subdomain')));

    }

    public function testSetGetPropertyRequired()
    {

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');

        $service = new LaravelService($model, new ServiceHelper());
        $service->setProperty('name');
        $service->setPropertyRequired('name', true);
        $this->assertTrue($service->isPropertyRequired('name'));
        $this->assertTrue(is_null($service->isPropertyRequired('subdomain')));

    }

    public function testAddProperty()
    {

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');

        $service = new LaravelService($model, new ServiceHelper());
        $service->addProperty('name', 'string', true, true, true);
        $this->assertFalse(is_null($service->getProperty('name')));
        $this->assertEquals('string', $service->getPropertyType('name'));
        $this->assertTrue($service->isPropertyRequired('name'));
        $this->assertTrue($service->isPropertyRead('name'));
        $this->assertTrue($service->isPropertyWrite('name'));

    }

    public function testFilterTableColumns()
    {

        $expected = [
            'created_at',
            'updated_at'
        ];

        $stringType = Mockery::mock('Doctrine\DBAL\Types\StringType');
        $stringType->shouldReceive('getName')->andReturn('string');

        $nameColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $nameColumn->shouldReceive('getName')->andReturn('name');
        $nameColumn->shouldReceive('getType')->andReturn($stringType);

        $subdomainColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $subdomainColumn->shouldReceive('getName')->andReturn('subdomain');
        $subdomainColumn->shouldReceive('getType')->andReturn($stringType);

        $integerType = Mockery::mock('Doctrine\DBAL\Types\IntegerType');
        $integerType->shouldReceive('getName')->andReturn('integer');

        $integerColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $integerColumn->shouldReceive('getName')->andReturn('id');
        $integerColumn->shouldReceive('getType')->andReturn($integerType);

        $returnArray = [
            'id' => $integerColumn,
            'subdomain' => $subdomainColumn,
            'name' => $nameColumn,
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getDates')->andReturn($expected);
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());
        $service->setTable();
        $service->setSchema();
        $service->setColumns();

        $service->filterTableColumns();

        $expected = [
            'id' => [
                'type' => 'integer',
                'read' => true,
                'write' => true,
                'required' => false
            ],
            'subdomain' => [
                'type' => 'string',
                'read' => true,
                'write' => true,
                'required' => false
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
            ],
            'updated_at' => [
                'type' => '\Carbon\Carbon',
                'read' => true,
                'write' => true,
                'required' => false
            ]
        ];
        $this->assertEquals($expected, $service->getProperties());

    }

    public function testSetDefaults()
    {

        $expected = [
            'created_at',
            'updated_at'
        ];

        $stringType = Mockery::mock('Doctrine\DBAL\Types\StringType');
        $stringType->shouldReceive('getName')->andReturn('string');

        $nameColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $nameColumn->shouldReceive('getName')->andReturn('name');
        $nameColumn->shouldReceive('getType')->andReturn($stringType);

        $subdomainColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $subdomainColumn->shouldReceive('getName')->andReturn('subdomain');
        $subdomainColumn->shouldReceive('getType')->andReturn($stringType);

        $integerType = Mockery::mock('Doctrine\DBAL\Types\IntegerType');
        $integerType->shouldReceive('getName')->andReturn('integer');

        $integerColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $integerColumn->shouldReceive('getName')->andReturn('id');
        $integerColumn->shouldReceive('getType')->andReturn($integerType);

        $returnArray = [
            'id' => $integerColumn,
            'subdomain' => $subdomainColumn,
            'name' => $nameColumn,
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getDates')->andReturn($expected);
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());

        $actual = $service->getProperties();

        $expected = [
            'id' => [
                'type' => 'integer',
                'read' => true,
                'write' => true,
                'required' => false
            ],
            'subdomain' => [
                'type' => 'string',
                'read' => true,
                'write' => true,
                'required' => false
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
            ],
            'updated_at' => [
                'type' => '\Carbon\Carbon',
                'read' => true,
                'write' => true,
                'required' => false
            ]
        ];
        $this->assertEquals($expected, $actual);

    }

    public function testGetTableProperties()
    {

        $expected = [
            'created_at',
            'updated_at'
        ];

        $stringType = Mockery::mock('Doctrine\DBAL\Types\StringType');
        $stringType->shouldReceive('getName')->andReturn('string');

        $nameColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $nameColumn->shouldReceive('getName')->andReturn('name');
        $nameColumn->shouldReceive('getType')->andReturn($stringType);

        $subdomainColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $subdomainColumn->shouldReceive('getName')->andReturn('subdomain');
        $subdomainColumn->shouldReceive('getType')->andReturn($stringType);

        $integerType = Mockery::mock('Doctrine\DBAL\Types\IntegerType');
        $integerType->shouldReceive('getName')->andReturn('integer');

        $integerColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $integerColumn->shouldReceive('getName')->andReturn('id');
        $integerColumn->shouldReceive('getType')->andReturn($integerType);

        $returnArray = [
            'id' => $integerColumn,
            'subdomain' => $subdomainColumn,
            'name' => $nameColumn,
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getDates')->andReturn($expected);
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());

        $service->setDefaults();

        $expected = [
            'id' => [
                'type' => 'integer',
                'read' => true,
                'write' => true,
                'required' => false
            ],
            'subdomain' => [
                'type' => 'string',
                'read' => true,
                'write' => true,
                'required' => false
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
            ],
            'updated_at' => [
                'type' => '\Carbon\Carbon',
                'read' => true,
                'write' => true,
                'required' => false
            ]
        ];
        $this->assertEquals($expected, $service->getTableProperties());

    }

    public function testGetModelTableInfo()
    {

        $expected = [
            'created_at',
            'updated_at'
        ];

        $stringType = Mockery::mock('Doctrine\DBAL\Types\StringType');
        $stringType->shouldReceive('getName')->andReturn('string');

        $nameColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $nameColumn->shouldReceive('getName')->andReturn('name');
        $nameColumn->shouldReceive('getType')->andReturn($stringType);

        $subdomainColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $subdomainColumn->shouldReceive('getName')->andReturn('subdomain');
        $subdomainColumn->shouldReceive('getType')->andReturn($stringType);

        $integerType = Mockery::mock('Doctrine\DBAL\Types\IntegerType');
        $integerType->shouldReceive('getName')->andReturn('integer');

        $integerColumn = Mockery::mock('Doctrine\DBAL\Schema\Column');
        $integerColumn->shouldReceive('getName')->andReturn('id');
        $integerColumn->shouldReceive('getType')->andReturn($integerType);

        $returnArray = [
            'id' => $integerColumn,
            'subdomain' => $subdomainColumn,
            'name' => $nameColumn,
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ];

        $platform = Mockery::mock('Doctrine\DBAL\Platforms\MySqlPlatform');
        $platform->shouldReceive('registerDoctrineTypeMapping')
            ->withArgs(['enum', 'string']);

        $mysqlSchemaManager = Mockery::mock('Doctrine\DBAL\Schema\MySqlSchemaManager');
        $mysqlSchemaManager->shouldReceive('getDatabasePlatform')
            ->andReturn($platform);
        $mysqlSchemaManager->shouldReceive('listTableColumns')
            ->with('companies')
            ->andReturn($returnArray);

        $connection = Mockery::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getDoctrineSchemaManager')
            ->with('companies')
            ->andReturn($mysqlSchemaManager);

        $model = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $model->shouldReceive('getDates')->andReturn($expected);
        $model->shouldReceive('getTable')->andReturn('companies');
        $model->shouldReceive('getConnection')->andReturn($connection);

        $service = new LaravelService($model, new ServiceHelper());

        $service->setDefaults();

        $expected = [
            'properties' => [
                'id' => [
                    'type' => 'integer',
                    'read' => true,
                    'write' => true,
                    'required' => false
                ],
                'subdomain' => [
                    'type' => 'string',
                    'read' => true,
                    'write' => true,
                    'required' => false
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
                ],
                'updated_at' => [
                    'type' => '\Carbon\Carbon',
                    'read' => true,
                    'write' => true,
                    'required' => false
                ]
            ]
        ];
        $this->assertEquals($expected, $service->getModelTableInfo());

    }

}