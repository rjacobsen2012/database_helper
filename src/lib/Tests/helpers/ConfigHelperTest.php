<?php namespace Tests;

use Helpers\ConfigHelper;
use \Mockery;

class ConfigHelperTest extends \PHPUnit_Framework_TestCase
{

    protected $helper;

    public function setUp()
    {

        parent::setUp();
        $this->helper = new ConfigHelper();

    }

    public function testSetConfig()
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

        $this->helper->setConfig(
            $args[0],
            $args[1],
            $args[2],
            $args[3],
            $args[4],
            $args[5],
            $args[6]
        );

        $this->assertEquals($args[0], $this->helper->getType());
        $this->assertEquals($args[1], $this->helper->getHost());
        $this->assertEquals($args[2], $this->helper->getUser());
        $this->assertEquals($args[3], $this->helper->getPassword());
        $this->assertEquals($args[4], $this->helper->getDatabase());
        $this->assertEquals($args[5], $this->helper->getPort());
        $this->assertEquals($args[6], $this->helper->getSocket());

    }

    public function testSetGetTypePasses()
    {

        $this->setGetPasses('setType', 'getType', 'postgres');

    }

    public function testSetGetTypeFails()
    {

        $this->setGetFails('setType', "Config type parameter is not set.");

    }

    public function testSetGetHostPasses()
    {

        $this->setGetPasses('setHost', 'getHost', '122.22.222.22');

    }

    public function testSetGetHostFails()
    {

        $this->setGetFails('setHost', "Config host parameter is not set.");

    }

    public function testSetGetUserPasses()
    {

        $this->setGetPasses('setUser', 'getUser', 'rjacobsen');

    }

    public function testSetGetUserFails()
    {

        $this->setGetFails('setUser', "Config user parameter is not set.");

    }

    public function testSetGetPasswordPasses()
    {

        $this->setGetPasses('setPassword', 'getPassword', '1234');

    }

    public function testSetGetPasswordFails()
    {

        $this->setGetFails('setPassword', "Config password parameter is not set.");

    }

    public function testSetGetDatabasePasses()
    {

        $this->setGetPasses('setDatabase', 'getDatabase', 'database_name');

    }

    public function testSetGetDatabaseFails()
    {

        $this->setGetFails('setDatabase', "Config database parameter is not set.");

    }

    public function testSetGetPortPasses()
    {

        $this->setGetPasses('setPort', 'getPort', '1235');

    }

    public function testSetGetSocketPasses()
    {

        $this->setGetPasses('setSocket', 'getSocket', 'socket');

    }

    protected function setGetPasses($set, $get, $value)
    {

        $this->helper->$set($value);
        $this->assertEquals($value, $this->helper->$get());

    }

    protected function setGetFails($set, $message)
    {

        $mock = $this->getMock('ConfigHelper', [$set]);
        $exception = new \Exception($message);
        $mock->expects($this->any())
            ->method($set)
            ->will($this->throwException($exception));

        $e = null;
        $response = null;

        //test exception
        try {

            $this->helper->$set(null);

        } catch (\Exception $e) {

            $response = $e->getMessage();

        }

        $this->assertTrue(
            $e instanceof \Exception,
            "Method getResponse should have thrown an exception"
        );

        $this->assertEquals($message, $response);

    }

}
