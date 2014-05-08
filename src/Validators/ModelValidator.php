<?php namespace Validators;

use Contracts\ModelLoaderInterface;
use Contracts\ValidatorInterface;
use Drivers\Laravel\LaravelService;
use Drivers\Database\DatabaseConfig;
use Helpers\ServiceHelper;
use Illuminate\Database\Eloquent\Model;
use Loaders\ModelLoader;

/**
 * Class ModelValidator
 *
 * @package Validators
 */
class ModelValidator implements ValidatorInterface
{

    /**
     * @var null
     */
    protected $modelLoader = null;

    /**
     * @var array
     */
    protected $frameworks = [
        'laravel'
    ];

    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param                $model
     * @param DatabaseConfig $config
     *
     * @return mixed
     */
    public function validate($model, DatabaseConfig $config = null)
    {
        $this->setModelLoader(new ModelLoader());
        $this->model = $this->getModelLoader()->loadModel($model);

        return $this->checkFrameworks();
    }

    /**
     * @param ModelLoaderInterface $modelLoader
     */
    public function setModelLoader(ModelLoaderInterface $modelLoader)
    {
        $this->modelLoader = $modelLoader;
    }

    /**
     * @return \Loaders\ModelLoader
     */
    public function getModelLoader()
    {
        return $this->modelLoader;
    }

    /**
     * @return bool|LaravelService
     */
    public function checkFrameworks()
    {
        foreach ($this->frameworks as $framework) {

            $model = $this->checkFramework($framework);

            if ($model) {

                return $model;

            }

        }

        return false;
    }

    /**
     * @param $framework
     *
     * @return bool|LaravelService
     */
    public function checkFramework($framework)
    {
        switch ($framework) {

            case "laravel":

                return $this->isLaravel();

                break;

            default:

                return false;

        }
    }

    /**
     * @return bool|LaravelService
     */
    public function isLaravel()
    {

        if ($this->model && $this->model instanceof Model) {

            return new LaravelService(
                $this->model,
                new ServiceHelper()
            );

        }

        return false;

    }

}