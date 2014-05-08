<?php namespace Loaders;

use Contracts\ModelLoaderInterface;

/**
 * Class ModelLoader
 *
 * @package Loaders
 */
class ModelLoader implements ModelLoaderInterface
{

    /**
     * @param $model
     *
     * @return mixed
     */
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

    /**
     * @param $model
     *
     * @return string
     */
    public function getModelNameFromPath($model)
    {

        if (strpos($model, "/") !== false) {

            $parts = explode("/", $model);

            return $parts[(count($parts)-1)];

        }

        return $model;

    }

}

