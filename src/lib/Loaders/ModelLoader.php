<?php namespace Loaders;

class ModelLoader
{

    public function loadModel($model)
    {

        if (class_exists($model)) {

            return new $model();

        } else {

            return false;

        }

    }

}

