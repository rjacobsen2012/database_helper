<?php namespace DatabaseHelpers;

class ExceptionHandler extends \Exception
{

    public function errorMessage()
    {

        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
            .': '.$this->getMessage();
        return $errorMsg;

    }

}