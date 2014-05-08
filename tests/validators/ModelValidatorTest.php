<?php namespace validators;

use Drivers\Database\DatabaseService;
use Drivers\Laravel\LaravelService;
use \Mockery;

class ModelValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    public function testValidatePasses()
    {

        $modelValidator = new ModelValidator();

        $model = $modelValidator->validate(
            '/www/field-dresser/tests/fixtures/UserFixture'
        );

        $this->assertTrue($model instanceof LaravelService);

    }

    public function testValidateFails()
    {

        $modelValidator = new ModelValidator();

        $model = $modelValidator->validate(
            'User'
        );

        $this->assertFalse($model);

    }

    public function testCheckFramework()
    {

        $modelValidator = new ModelValidator();

        $valid = $modelValidator->checkFramework('codeigniter');

        $this->assertFalse($valid);

    }

}