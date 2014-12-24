<?php
namespace Cordial\Cordial;

//require_once realpath(dirname(__FILE__) . '/autoload.php');
//use \Cordial\CordialClient;
//use \Cordial\CordialException;

class Cordial {
echo 'error';
    private $apiKey;

    function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    function __call($name, $arguments) {
        if(!empty($arguments)){
            $arguments[0] = isset($arguments[0])?$arguments[0]:NULL;
            $arguments[1] = isset($arguments[1])?$arguments[1]:NULL;
            $arguments[2] = isset($arguments[2])?$arguments[2]:NULL;
        }else{
            $arguments[0] = NULL;
            $arguments[1] = NULL;
            $arguments[2] = NULL;
        }
        $res = $this->handleMethodName($name);
        $result = CordialClient::_request($res['requestType'],
            '/v1/'.strtolower($res['method']), 
            $this->apiKey,
            $arguments[0],
            $arguments[1],
            $arguments[2]
        );
        return $result;
    }

    private function handleMethodName($methodName) {
        $request = "GET";
        $method = "";
        
        if (substr($methodName, 0, 6) == 'getone') {
            $method = substr($methodName, 6);
            $request = "GETONE";
        } else
        if (substr($methodName, 0, 6) == 'update') {
            $method = substr($methodName, 6);
            $request = "PUT";
        } else
        if (substr($methodName, 0, 6) == 'create') {
            $method = substr($methodName, 6);
            $request = "POST";
        } else
        if (substr($methodName, 0, 6) == 'delete') {
            $method = substr($methodName, 6);
            $request = "DELETE";
        }else
        if (substr($methodName, 0, 3) == 'get') {
            $method = substr($methodName, 3);
            $request = "GET";
        }
        else{
            throw new CordialUnsupportedMethodException( $e );
            return [$e->getCode(), ['error'=>true, 'message'=>$e->getMessage()]];
        }
        return [
            'requestType' => $request,
            'method' => $method
        ];
    }
    

}
