<?php namespace Tests\repositories;

use Drivers\Database\Mysql\MysqlHelper;
use Drivers\Database\Mysql\MysqlRepository;
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

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getColumns($model);
        $this->assertTrue($found instanceof \mysqli);

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

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getColumns($model);
        $this->assertNull($found);

    }

    public function testGetTableColumnsRegularCasePasses()
    {

        $model = 'User';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$model."'")->andReturn($mysqli);
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

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getTableColumns($model);
        $this->assertTrue($found instanceof \mysqli);

    }

    public function testGetTableColumnsLowerCasePasses()
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

        $mysqliA = Mockery::mock('\mysqli');
        $mysqliA->num_rows = 0;

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE 'User'")->andReturn($mysqliA);
        $mysqliB = $mysqli;
        $mysqliB->num_rows = 1;
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE 'user'")->andReturn($mysqliB);
        $mysqli->shouldReceive('query')->with("SHOW COLUMNS FROM user")->andReturn($mysqliB);

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getTableColumns('User');
        $this->assertTrue($found instanceof \mysqli);

    }

    public function testGetTableColumnsThrowsException()
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

        $mysqliA = Mockery::mock('\mysqli');
        $mysqliA->num_rows = 0;

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE 'User'")->andReturn($mysqliA);
        $mysqliB = $mysqli;
        $mysqliB->num_rows = 0;
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE 'user'")->andReturn($mysqliB);

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $this->setExpectedException('Exception');

        $e = null;

        try {

            $found = $mysqlRepository->getTableColumns('User');

        } catch (Mockery\Exception $e) {



        }

        $this->assertTrue($e instanceof Mockery\Exception, "Method getResponse should have thrown an exception");

    }

    public function testGetColumnName()
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

        $column = ['Field' => 'name'];
        $name = $mysqlRepository->getColumnName($column);
        $this->assertEquals('name', $name);

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
        $this->assertEquals('varchar', $type);

    }

    public function testGetTableSchemaManager()
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

        $schema = $mysqlRepository->getTableSchemaManager();
        $this->assertNull($schema);

    }

    public function testGetModelDates()
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

        $dates = $mysqlRepository->getModelDates();
        $this->assertNull($dates);

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
        $required = $mysqlRepository->isRequired($column);
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
        $required = $mysqlRepository->isRequired($column);
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

    public function testGetModelTable()
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

        $model = 'user';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$model."'")->andReturn($mysqli);
        $mysqli->num_rows = 1;

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $mysqlRepository->checkForTable($model);
        $this->assertEquals($model, $mysqlRepository->getModelTable());

    }

    public function testFetchRow()
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

        $result_rows = [
            'Field' => 'id',
            'Type' => 'integer(10)',
            'Null' => 'NO'
        ];

        $model = 'user';

        $mysqli = Mockery::mock('\mysqli');
        $mysqli->shouldReceive('real_connect')->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW TABLES LIKE '".$model."'")->andReturn($mysqli);
        $mysqli->shouldReceive('query')->with("SHOW COLUMNS FROM ".$model)->andReturn($mysqli);
        $mysqli->shouldReceive('fetch_assoc')->once()->andReturn($result_rows);
        $mysqli->num_rows = 1;

        $mysqlRepository = new MysqlRepository($mysqli, $config, new MysqlHelper());
        $mysqlRepository->setDbConnection();

        $mysqlRepository->checkForTable($model);
        $found = $mysqlRepository->getColumns($model);
        $this->assertTrue($found instanceof \mysqli);
        $this->assertEquals($result_rows, $mysqlRepository->fetchRow());

    }

    public function testFilterTableFieldType()
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

        $this->assertEquals('string', $mysqlRepository->filterTableFieldType('varchar(45)'));
        $this->assertEquals('integer', $mysqlRepository->filterTableFieldType('integer(10)'));
        $this->assertEquals('float', $mysqlRepository->filterTableFieldType('float'));
        $this->assertEquals('boolean', $mysqlRepository->filterTableFieldType('boolean'));
        $this->assertEquals('mixed', $mysqlRepository->filterTableFieldType('mixed'));
        $this->assertEquals('', $mysqlRepository->filterTableFieldType('something'));

    }

    public function testFilterTableColumns()
    {

        $model = 'User';

        $result_rows = [
            [
                'Field' => 'id',
                'Type' => 'integer(10)',
                'Null' => 'NO'
            ],
            [
                'Field' => 'name',
                'Type' => 'string(16)',
                'Null' => 'YES'
            ],
            [
                'Field' => 'created_at',
                'Type' => 'timestamp',
                'Null' => 'YES'
            ]
        ];

        $count = 0;

        $mysqli_result = Mockery::mock('\mysqli_result');
        $mysqli_result->shouldReceive('fetch_assoc');

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
            ['fetchRow'],
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );
        $mysqlRepository->expects($this->at(0))
            ->method('fetchRow')
            ->willReturn($result_rows[0]);
        $mysqlRepository->expects($this->at(1))
            ->method('fetchRow')
            ->willReturn($result_rows[1]);
        $mysqlRepository->expects($this->at(2))
            ->method('fetchRow')
            ->willReturn($result_rows[2]);
        $mysqlRepository->expects($this->at(3))
            ->method('fetchRow')
            ->willReturn(false);
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getColumns($model);
        $this->assertTrue($found instanceof \mysqli);

        $mysqlRepository->filterTableColumns();

    }

    public function testSetGetProperty()
    {

        $mysqlRepository = new MysqlRepository(
            Mockery::mock('\mysqli'),
            Mockery::mock('Helpers\ConfigHelper'),
            new MysqlHelper()
        );

        $mysqlRepository->setProperty('subdomain');
        $property = $mysqlRepository->getProperty('subdomain');
        $this->assertFalse(is_null($property));

        $property = $mysqlRepository->getProperty('name');
        $this->assertTrue(is_null($property));

    }

    public function testSetGetPropertyType()
    {

        $mysqlRepository = new MysqlRepository(
            Mockery::mock('\mysqli'),
            Mockery::mock('Helpers\ConfigHelper'),
            new MysqlHelper()
        );

        $mysqlRepository->setProperty('subdomain');

        $mysqlRepository->setPropertyType('subdomain', 'string');
        $this->assertEquals('string', $mysqlRepository->getPropertyType('subdomain'));
        $this->assertNull($mysqlRepository->getPropertyType('name'));

    }

    public function testSetGetPropertyRead()
    {

        $mysqlRepository = new MysqlRepository(
            Mockery::mock('\mysqli'),
            Mockery::mock('Helpers\ConfigHelper'),
            new MysqlHelper()
        );

        $mysqlRepository->setProperty('subdomain');

        $mysqlRepository->setPropertyRead('subdomain', true);
        $this->assertTrue($mysqlRepository->getPropertyRead('subdomain'));
        $this->assertNull($mysqlRepository->getPropertyRead('name'));

    }

    public function testSetGetPropertyWrite()
    {

        $mysqlRepository = new MysqlRepository(
            Mockery::mock('\mysqli'),
            Mockery::mock('Helpers\ConfigHelper'),
            new MysqlHelper()
        );

        $mysqlRepository->setProperty('subdomain');

        $mysqlRepository->setPropertyWrite('subdomain', true);
        $this->assertTrue($mysqlRepository->getPropertyWrite('subdomain'));
        $this->assertNull($mysqlRepository->getPropertyWrite('name'));

    }

    public function testSetGetPropertyRequired()
    {

        $mysqlRepository = new MysqlRepository(
            Mockery::mock('\mysqli'),
            Mockery::mock('Helpers\ConfigHelper'),
            new MysqlHelper()
        );

        $mysqlRepository->setProperty('subdomain');

        $mysqlRepository->setPropertyRequired('subdomain', true);
        $this->assertTrue($mysqlRepository->getPropertyRequired('subdomain'));
        $this->assertNull($mysqlRepository->getPropertyRequired('name'));

    }

    public function testGetTableProperties()
    {

        $model = 'User';

        $result_rows = [
            [
                'Field' => 'id',
                'Type' => 'integer(10)',
                'Null' => 'NO'
            ],
            [
                'Field' => 'name',
                'Type' => 'string(16)',
                'Null' => 'YES'
            ],
            [
                'Field' => 'created_at',
                'Type' => 'timestamp',
                'Null' => 'YES'
            ]
        ];

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

        $count = 0;

        $mysqli_result = Mockery::mock('\mysqli_result');
        $mysqli_result->shouldReceive('fetch_assoc');

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
            ['fetchRow'],
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );
        $mysqlRepository->expects($this->at(0))
            ->method('fetchRow')
            ->willReturn($result_rows[0]);
        $mysqlRepository->expects($this->at(1))
            ->method('fetchRow')
            ->willReturn($result_rows[1]);
        $mysqlRepository->expects($this->at(2))
            ->method('fetchRow')
            ->willReturn($result_rows[2]);
        $mysqlRepository->expects($this->at(3))
            ->method('fetchRow')
            ->willReturn(false);
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getColumns($model);
        $this->assertTrue($found instanceof \mysqli);

        $mysqlRepository->filterTableColumns();

        $this->assertEquals($expected, $mysqlRepository->getTableProperties());

    }

    public function testGetModelTableInfo()
    {

        $model = 'User';

        $result_rows = [
            [
                'Field' => 'id',
                'Type' => 'integer(10)',
                'Null' => 'NO'
            ],
            [
                'Field' => 'name',
                'Type' => 'string(16)',
                'Null' => 'YES'
            ],
            [
                'Field' => 'created_at',
                'Type' => 'timestamp',
                'Null' => 'YES'
            ]
        ];

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

        $count = 0;

        $mysqli_result = Mockery::mock('\mysqli_result');
        $mysqli_result->shouldReceive('fetch_assoc');

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
            ['fetchRow'],
            [
                $mysqli,
                $config,
                new MysqlHelper()
            ]
        );
        $mysqlRepository->expects($this->at(0))
            ->method('fetchRow')
            ->willReturn($result_rows[0]);
        $mysqlRepository->expects($this->at(1))
            ->method('fetchRow')
            ->willReturn($result_rows[1]);
        $mysqlRepository->expects($this->at(2))
            ->method('fetchRow')
            ->willReturn($result_rows[2]);
        $mysqlRepository->expects($this->at(3))
            ->method('fetchRow')
            ->willReturn(false);
        $mysqlRepository->setDbConnection();
        $found = $mysqlRepository->getColumns($model);
        $this->assertTrue($found instanceof \mysqli);

        $mysqlRepository->filterTableColumns();

        $this->assertEquals($expected, $mysqlRepository->getModelTableInfo());

    }

}