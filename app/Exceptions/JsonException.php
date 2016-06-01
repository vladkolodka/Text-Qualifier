<?php
namespace Qualifier\Exceptions;

class JsonException extends \Exception{
    public function __construct($message) {
        parent::__construct($message, 0, $this);
    }
    public function getLocaleMessage(){
        return trans('errors.' . $this->message);
    }
}