<?php namespace Tests\loaders;

use Loaders\ModelLoader;
use \Mockery;

class ModelLoaderTest extends \PHPUnit_Framework_TestCase
{

    /** @var \Loaders\ModelLoader $loader */
    protected $loader;

    public function setUp()
    {

        parent::setUp();
        $this->loader = new ModelLoader();

    }

    public function testLoadModelWithPath()
    {
        $helper = $this->loader->loadModel('/www/field-dresser/src/lib/Mapper');
        $this->assertTrue($helper instanceof \Mapper);

    }

    public function testLoadModelPasses()
    {
        $helper = $this->loader->loadModel('Mapper');
        $this->assertTrue($helper instanceof \Mapper);

    }

    public function testLoadModelFails()
    {

        $helper = $this->loader->loadModel('John');
        $this->assertFalse($helper);

    }

    public function testGetModelNameWithPath()
    {

        $this->assertEquals(
            'Mapper',
            $this->loader->getModelNameFromPath('/www/field-dresser/src/lib/Mapper')
        );

    }

    public function testGetModelNameWithoutPath()
    {

        $this->assertEquals(
            'Mapper',
            $this->loader->getModelNameFromPath('Mapper')
        );

    }

}
