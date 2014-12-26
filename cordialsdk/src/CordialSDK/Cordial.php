<?php

namespace CordialSDK;

class Cordial
{

    private $apiKey;

    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return type
     */
    function __call($name, $arguments)
    {
        $client = new CordialClient();

        try {
            $params = $client->parseArguments($arguments);
            $res = $this->handleMethodName($name);
            $result = $client->_request($res['requestType'], '/v1/' . strtolower($res['method']), $this->apiKey, $params['query'], $params['page'], $params['per_page']);
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
        return $result;
    }

    /**
     * 
     * @param type $methodName
     * @return type
     * @throws Exceptions\CordialUnsupportedMethodException
     */
    private function handleMethodName($methodName)
    {
        $request = "";
        $method = "";

        if (substr($methodName, 0, 6) == 'getone')
        {
            $method = substr($methodName, 6);
            $request = "GETONE";
        } else
        if (substr($methodName, 0, 6) == 'update')
        {
            $method = substr($methodName, 6);
            $request = "PUT";
        } else
        if (substr($methodName, 0, 6) == 'create')
        {
            $method = substr($methodName, 6);
            $request = "POST";
        } else
        if (substr($methodName, 0, 6) == 'delete')
        {
            $method = substr($methodName, 6);
            $request = "DELETE";
        } else
        if (substr($methodName, 0, 3) == 'get')
        {
            $method = substr($methodName, 3);
            $request = "GET";
        } else
        {
            throw new Exceptions\CordialUnsupportedMethodException ();
        }

        return [
            'requestType' => $request,
            'method' => $method
        ];
    }

}
