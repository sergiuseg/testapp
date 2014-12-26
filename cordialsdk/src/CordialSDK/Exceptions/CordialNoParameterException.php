<?php



namespace CordialSDK\Exceptions;


class CordialNoParameterException  extends \Exception {
    protected $code = 101;

    public function __construct($message = "Incorrect parameters", \Exception $previous = null){
        parent::__construct($message, $this->code, $previous);
    }
}

