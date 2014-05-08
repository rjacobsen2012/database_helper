<?php namespace Contracts;

/**
 * Interface ModelLoaderInterface
 *
 * @package Contracts
 */
interface ModelLoaderInterface
{

    /**
     * @param $model
     *
     * @return mixed
     */
    public function loadModel($model);

    /**
     * @param $model
     *
     * @return string
     */
    public function getModelNameFromPath($model);

}