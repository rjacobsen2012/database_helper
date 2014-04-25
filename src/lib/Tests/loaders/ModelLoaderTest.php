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

    public function testCheckIfModelExistsLocally()
    {

//        $this->loader->loadModel('Mapper');
//        $this->assertFalse($this->loader->checkIfModelExistsLocally());

    }

}
