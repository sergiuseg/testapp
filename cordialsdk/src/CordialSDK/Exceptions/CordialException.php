<?php

namespace CordialSDK\Exceptions;

/**
 * CordialException - Wrapper for \Exception class
 *
 * @package  Cordial
 * @author   
 */
class CordialException extends \Exception
{

    protected $code = 400;

    /**
     * Constructs a Cordial\Exception
     *
     * @param string     $message  Message for the Exception.
     * @param int        $code     Error code.
     * @param \Exception $previous Previous Exception.
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        if (isset($message['_debug']))
        {
            $message = $message['_debug']['message'];
        } else
            $message = isset($message['message']) ? $message['message'] : $message['error'];
        
        parent::__construct($message, $this->code, $previous);
    }

}
