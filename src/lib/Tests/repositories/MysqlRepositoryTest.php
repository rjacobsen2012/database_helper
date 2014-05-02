<?php namespace Tests\repositories;

use Helpers\MysqlHelper;
use Drivers\Database\Mysql\MysqlRepository;
use Helpers\LaravelHelper;
use Drivers\Laravel\LaravelService;
use Helpers\ConfigHelper;
use \Mockery;

class MysqlRepositoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testSetGetDbConnection()
    {

        $mysqli = Mockery::mock('mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn(true);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $this->assertFalse(is_null($mysqlRepository->getDbConnection()));

    }

    public function testTestDbConnectionFailsPasses()
    {

        $mysqli = Mockery::mock('mysqli');

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = $this->getMock(
            'Drivers\Database\Mysql\MysqlRepository',
            ['setDbConnection', 'getDbConnection'],
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );

        $mysqlRepository->expects($this->any())
            ->method('setDbConnection')
            ->withAnyParameters()
            ->willReturn(null);

        $mysqlRepository->expects($this->any())
            ->method('getDbConnection')
            ->withAnyParameters()
            ->willReturn($mysqli);

        $error = $mysqlRepository->testDbConnectionFails();
        $this->assertEquals(false, $error);

    }

    public function testTestDbConnectionFailsFails()
    {

        $mysqli = Mockery::mock('mysqli');

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = $this->getMock(
            'Drivers\Database\Mysql\MysqlRepository',
            ['setDbConnection', 'getDbConnection'],
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );

        $mysqlRepository->expects($this->any())
            ->method('setDbConnection')
            ->withAnyParameters()
            ->willReturn(null);

        $mysqlRepository->expects($this->any())
            ->method('getDbConnection')
            ->withAnyParameters()
            ->willReturn(null);

        $error = $mysqlRepository->testDbConnectionFails();
        $this->assertEquals(true, $error);

    }

    public function testCheckForTablePasses()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$model."'")->andReturn($mysqli);
        $mysqli->num_rows = 1;

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->checkForTable($model);
        $this->assertTrue($found);

    }

    public function testGetSchema()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $database = $mysqlRepository->getSchema();
        $this->assertEquals('newdb', $database);

    }

    public function testGetModelDates()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $database = $mysqlRepository->getModelDates();
        $this->assertNull($database);

    }

    public function testGetTableSchemaManager()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $database = $mysqlRepository->getTableSchemaManager();
        $this->assertNull($database);

    }

    public function testCheckForTableFails()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$model."'")->andReturn($mysqli);
        $mysqli->num_rows = 0;

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->checkForTable($model);
        $this->assertFalse($found);

    }

    public function testGetColumnsPasses()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW COLUMNS FROM ".$model)->andReturn($mysqli);
        $mysqli->num_rows = 1;

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = $this->getMock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                'filterColumns'
            ],
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );
        $mysqlRepository->expects($this->any())
            ->method('filterColumns')
            ->withAnyParameters()
            ->willReturn([]);

        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getColumns($model);
        $this->assertEquals([], $found);

    }

    public function testGetColumnsFails()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW COLUMNS FROM ".$model)->andReturn($mysqli);
        $mysqli->num_rows = 0;

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = $this->getMock(
            'Drivers\Database\Mysql\MysqlRepository',
            [
                'filterColumns'
            ],
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );

        $mysqlRepository->setDbConnection();
        $this->assertNull($mysqlRepository->getColumns($model));

    }

    public function testFilterColumns()
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

        $model = 'User';

        $mysqli = $this->getMock(
            '\mysqli',
            ['query', 'fetch_assoc', 'real_connect', 'num_rows']
        );
        $mysqli->num_rows = 1;
        $mysqli->expects($this->any())
            ->method('real_connect')
            ->withAnyParameters()
            ->willReturn($mysqli);

        $mysqli->expects($this->any())
            ->method('num_rows')
            ->withAnyParameters()
            ->willReturn(1);

        $mysqli->expects($this->any())
            ->method('query')
            ->withAnyParameters()
            ->willReturn($mysqli);

        $mysqli->expects($this->at(2))
            ->method('fetch_assoc')
            ->withAnyParameters()
            ->willReturn($columns['id']);

        $mysqli->expects($this->at(3))
            ->method('fetch_assoc')
            ->withAnyParameters()
            ->willReturn($columns['name']);

        $mysqli->expects($this->at(4))
            ->method('fetch_assoc')
            ->withAnyParameters()
            ->willReturn($columns['subdomain']);

        $mysqli->expects($this->at(5))
            ->method('fetch_assoc')
            ->withAnyParameters()
            ->willReturn($columns['created_at']);

        $mysqli->expects($this->at(6))
            ->method('fetch_assoc')
            ->withAnyParameters()
            ->willReturn(false);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $mysqlRepository->getTable('User');
        $columnsParsed = $mysqlRepository->filterColumns($mysqli);
        $this->assertEquals($columns, $columnsParsed);

    }

    public function testGetTableRegular()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$model."'")->andReturn($mysqli);
        $mysqli->num_rows = 1;

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $this->assertEquals('User', $mysqlRepository->getTable('User'));

    }

    public function testGetTableRegularPlural()
    {

        $modelA = 'User';
        $modelB = 'Users';

        $mysqliA = Mockery::mock('\mysqli');
        $mysqliA->num_rows = 0;
        $mysqliB = Mockery::mock('\mysqli');
        $mysqliB->num_rows = 1;

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelA."'")->andReturn($mysqliA);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelB."'")->andReturn($mysqliB);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $this->assertEquals('Users', $mysqlRepository->getTable('User'));

    }

    public function testGetTableLower()
    {

        $modelA = 'User';
        $modelB = 'Users';
        $modelC = 'user';

        $mysqliA = Mockery::mock('\mysqli');
        $mysqliA->num_rows = 0;
        $mysqliB = Mockery::mock('\mysqli');
        $mysqliB->num_rows = 0;
        $mysqliC = Mockery::mock('\mysqli');
        $mysqliC->num_rows = 1;

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelA."'")->andReturn($mysqliA);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelB."'")->andReturn($mysqliB);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelC."'")->andReturn($mysqliC);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $this->assertEquals('user', $mysqlRepository->getTable('User'));

    }

    public function testGetTableLowerPlural()
    {

        $modelA = 'User';
        $modelB = 'Users';
        $modelC = 'user';
        $modelD = 'users';

        $mysqliA = Mockery::mock('\mysqli');
        $mysqliA->num_rows = 0;
        $mysqliB = Mockery::mock('\mysqli');
        $mysqliB->num_rows = 0;
        $mysqliC = Mockery::mock('\mysqli');
        $mysqliC->num_rows = 0;
        $mysqliD = Mockery::mock('\mysqli');
        $mysqliD->num_rows = 1;

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelA."'")->andReturn($mysqliA);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelB."'")->andReturn($mysqliB);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelC."'")->andReturn($mysqliC);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelD."'")->andReturn($mysqliD);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $this->assertEquals('users', $mysqlRepository->getTable('User'));

    }

    public function testGetTableNotFound()
    {

        $modelA = 'User';
        $modelB = 'Users';
        $modelC = 'user';
        $modelD = 'users';

        $mysqliA = Mockery::mock('\mysqli');
        $mysqliA->num_rows = 0;
        $mysqliB = Mockery::mock('\mysqli');
        $mysqliB->num_rows = 0;
        $mysqliC = Mockery::mock('\mysqli');
        $mysqliC->num_rows = 0;
        $mysqliD = Mockery::mock('\mysqli');
        $mysqliD->num_rows = 0;

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelA."'")->andReturn($mysqliA);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelB."'")->andReturn($mysqliB);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelC."'")->andReturn($mysqliC);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$modelD."'")->andReturn($mysqliD);

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $this->assertNull($mysqlRepository->getTable('User'));

    }

    public function testGetColumnType()
    {

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $column = ['Type' => 'varchar'];
        $type = $mysqlRepository->getColumnType($column);
        $this->assertEquals('string', $type);

        $column = ['Type' => 'timestamp'];
        $type = $mysqlRepository->getColumnType($column);
        $this->assertEquals('\Carbon\Carbon', $type);

    }

    public function testIsRequiredTrue()
    {

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $column = ['Null' => 'NO'];
        $required = $mysqlRepository->getRequired($column);
        $this->assertTrue($required);

    }

    public function testIsRequiredFalse()
    {

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $column = ['Null' => 'YES'];
        $required = $mysqlRepository->getRequired($column);
        $this->assertFalse($required);

    }

    public function testIsColumnDateTrue()
    {

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $column = ['Type' => 'datetime'];
        $isdate = $mysqlRepository->isColumnDate($column);
        $this->assertTrue($isdate);

        $column = ['Type' => 'timestamp'];
        $isdate = $mysqlRepository->isColumnDate($column);
        $this->assertTrue($isdate);

    }

    public function testIsColumnDateFalse()
    {

        $config = Mockery::mock('Helpers\ConfigHelper');
        $config->shouldReceive('setConfig')->withArgs(
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
        $config->shouldReceive('getHost')->andReturn('123.45.567.8');
        $config->shouldReceive('getUser')->andReturn('someuser');
        $config->shouldReceive('getPassword')->andReturn('1234');
        $config->shouldReceive('getDatabase')->andReturn('newdb');
        $config->shouldReceive('getPort')->andReturn('someport');
        $config->shouldReceive('getSocket')->andReturn('somesocket');
        $config->setConfig(
            'mysql',
            '123.45.567.8',
            'someuser',
            '1234',
            'newdb',
            'someport',
            'somesocket'
        );

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $column = ['Type' => 'varchar'];
        $isdate = $mysqlRepository->isColumnDate($column);
        $this->assertFalse($isdate);

    }

}