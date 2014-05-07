<?php namespace Contracts;

interface ModelLoaderInterface
{

    public function loadModel($model);

    public function getModelNameFromPath($model);

}