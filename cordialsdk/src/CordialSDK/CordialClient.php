<?php

namespace CordialSDK;

/**
 * CordialClient - Main class for Cordial initialization and communication
 *
 * @package  Cordial
 * @author   Bandfarm
 */
final class CordialClient
{

    const HOST_NAME = 'syegorchev.api.dev.cordial.io';
    /**
     * 
     * @param type $method
     * @param type $relativeUrl
     * @param type $apiKey
     * @param type $data
     * @param type $page
     * @param type $per_page
     * @return type
     * @throws CordialException
     * @throws Exceptions\CordialException
     */
    public static function _request($method, $relativeUrl, $apiKey, $data = NULL, $page, $per_page)
    {
        if ($data === '[]')
        {
            $data = '{}';
        }

        $headers = self::_getRequestHeaders();

        $url = self::HOST_NAME . $relativeUrl;
        if (($method === 'GETONE' || $method === 'DELETE') && !empty($data) )
        {
            $data = array_change_key_case($data, CASE_LOWER);
            $url .= '/' . $data['id'];
        }
        
        if ($method === 'GET' && !empty($data))
        {
            $url .= '?' . http_build_query($data) . '&' . 'page=' . $page . '&per_page=' . $per_page;
        }

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_USERPWD, $apiKey . ":" . $apiKey);
        curl_setopt($rest, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        
        if ($method === 'POST')
        {
            $queryOptions = json_encode($data);
            curl_setopt($rest, CURLOPT_POST, 1);
            curl_setopt($rest, CURLOPT_POSTFIELDS, $queryOptions);
        }
        
        if ($method === 'PUT')
        {
            $queryOptions = json_encode($data);
            curl_setopt($rest, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($rest, CURLOPT_POSTFIELDS, $queryOptions);
        }
        
        if ($method === 'DELETE')
        {
            curl_setopt($rest, CURLOPT_CUSTOMREQUEST, $method);
        }
        
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($rest);
        $status = curl_getinfo($rest, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($rest, CURLINFO_CONTENT_TYPE);
        
        if (curl_errno($rest))
        {
            throw new CordialException(curl_error($rest), curl_errno($rest));
        }
        
        curl_close($rest);
        if (strpos($contentType, 'text/html') !== false)
        {
            throw new CordialException('Bad Request', -1);
        }

        $decoded = json_decode($response, true);

        if (isset($decoded['error']))
        {
            throw new Exceptions\CordialException($decoded);
        }
        return $decoded;
    }

    
    /**
     * 
     * @param type $params
     * @return boolean
     */
    public static function checkCorrectsOfParams($params)
    {
        foreach ($params as $key => $value)
        {
            if (is_numeric($key) || empty($key))
                return false;
        }
        return true;
    }
    /**
     * 
     * @param type $params
     * @return array
     * @throws Exceptions\CordialNoParameterException
     */
    public static function parseArguments($params)
    {

        $result = array();

        $result['page'] = (isset($params[1])) ? $params[1] : 1;
        $result['per_page'] = (isset($params[2])) ? $params[2] : 25;


        if (isset($params[0]) && !empty($params[0]))
        {
            if (self::checkCorrectsOfParams($params[0]))
            {
                $result['query'] = $params[0];
            } else
            {
                throw new Exceptions\CordialNoParameterException();
            }
        } else
        {
            $result['query'] = '';
        }

        return $result;
    }
    /**
     * 
     * @return string
     */
    public static function _getRequestHeaders()
    {
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Cache-Control: no-cache';
        return $headers;
    }

}
