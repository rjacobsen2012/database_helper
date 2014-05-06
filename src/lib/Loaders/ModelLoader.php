<?php namespace Loaders;

use Contracts\ModelLoaderInterface;
use Helpers\StringHelper;

class ModelLoader implements ModelLoaderInterface
{

    public function loadModel($model)
    {

        $realpath = realpath("$model.php");

        if ($realpath) {

            require_once($realpath);

            $loadModel = $this->getModelNameFromPath($model);

            return new $loadModel();

        } elseif (class_exists($model)) {

            return new $model();

        } else {

            return false;

        }

    }

    public function getModelNameFromPath($model)
    {

        if (strpos($model, "/") !== false) {

            $parts = StringHelper::explodeString($model, "/");

            return $parts[(count($parts)-1)];

        }

        return $model;

    }

}

