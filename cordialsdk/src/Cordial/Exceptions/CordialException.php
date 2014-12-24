<?php

namespace Cordial;

/**
 * CordialException - Wrapper for \Exception class
 *
 * @package  Cordial
 * @author   
 */
class CordialException extends \Exception
{

  /**
   * Constructs a Cordial\Exception
   *
   * @param string     $message  Message for the Exception.
   * @param int        $code     Error code.
   * @param \Exception $previous Previous Exception.
   */
  public function __construct($message, $code = 0,
                              \Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

}