<?php
namespace Qualifier\Exceptions;

class JsonException extends \Exception{
    private $isRaw = false;
    
    public function __construct($message, bool $raw = false) {
        $this->isRaw = $raw;
        parent::__construct($message, 0, $this);
    }
    public function getLocaleMessage(){
        return $this->isRaw ? $this->message : trans('errors.' . $this->message);
    }
}