<?php

namespace CordialSDK\Exceptions;


class CordialUnsupportedMethodException  extends \Exception {
    protected $code = 400;

    public function __construct($message = "Unsupported method", \Exception $previous = null){
        parent::__construct($message, $this->code, $previous);
    }
}

