<?php namespace helpers;

use Helpers\DatabaseHelper;

class DatabaseHelperTest extends \PHPUnit_Framework_TestCase
{

    protected $helper;

    public function setUp()
    {

        parent::setUp();
        $this->helper = new DatabaseHelper();

    }

    public function testInstance()
    {

        $this->assertInstanceOf('Contracts\HelperInterface', $this->helper);

    }

    public function testIsString()
    {

        $types = [
            'varchar(45)',
            'string',
            'text',
            'date',
            'timestamp',
            'guid',
            'datetime'
        ];

        foreach ($types as $arg) {

            $this->assertTrue($this->helper->isString($arg));

        }

        $this->assertFalse($this->helper->isString('tom'));

    }

    public function testIsInteger()
    {

        $types = [
            'integer(10)',
            'bigint(25)',
            'smallint(1)'
        ];

        foreach ($types as $arg) {

            $this->assertTrue($this->helper->isInteger($arg));

        }

        $this->assertFalse($this->helper->isInteger('tom'));

    }

    public function testIsDecimal()
    {

        $types = [
            'decimal(10)',
            'float(1)'
        ];

        foreach ($types as $arg) {

            $this->assertTrue($this->helper->isDecimal($arg));

        }

        $this->assertFalse($this->helper->isDecimal('tom'));

    }

    public function testIsBoolean()
    {

        $types = [
            'boolean'
        ];

        foreach ($types as $arg) {

            $this->assertTrue($this->helper->isBoolean($arg));

        }

        $this->assertFalse($this->helper->isBoolean('tom'));

    }

    public function testIsMixed()
    {

        $types = [
            'mixed'
        ];

        foreach ($types as $arg) {

            $this->assertTrue($this->helper->isMixed($arg));

        }

        $this->assertFalse($this->helper->isMixed('tom'));

    }

    public function testFilterTableFieldType()
    {

        $types = [
            'string' => 'varchar(45)',
            'integer' => 'integer(11)',
            'float' => 'float',
            'boolean' => 'boolean',
            'mixed' => 'mixed',
            '' => 'joe'
        ];

        foreach ($types as $type => $test) {

            $this->assertEquals($type, $this->helper->filterTableFieldType($test));

        }

    }

}

