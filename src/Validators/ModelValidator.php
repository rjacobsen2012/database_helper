<?php namespace Validators;

use Contracts\ModelLoaderInterface;
use Contracts\ValidatorInterface;
use Drivers\Laravel\LaravelService;
use Helpers\ConfigHelper;
use Helpers\LaravelHelper;
use Illuminate\Database\Eloquent\Model;
use Loaders\ModelLoader;

class ModelValidator implements ValidatorInterface
{

    protected $modelLoader = null;

    protected $frameworks = [
        'laravel'
    ];

    protected $model;

    public function validate($model, ConfigHelper $config = null)
    {
        $this->setModelLoader(new ModelLoader());
        $this->model = $this->getModelLoader()->loadModel($model);

        return $this->checkFrameworks();
    }

    public function setModelLoader(ModelLoaderInterface $modelLoader)
    {
        $this->modelLoader = $modelLoader;
    }

    public function getModelLoader()
    {
        return $this->modelLoader;
    }

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

    public function isLaravel()
    {

        if ($this->model && $this->model instanceof Model) {

            return new LaravelService(
                $this->model,
                new LaravelHelper()
            );

        }

        return false;

    }

}