<?php

namespace Cordial;

/**
 * CordialClient - Main class for Cordial initialization and communication
 *
 * @package  Cordial
 * @author   Bandfarm
 */
final class CordialClient {

    const HOST_NAME = 'syegorchev.api.dev.cordial.io';

    public static function _request($method, $relativeUrl, $apiKey, $data = NULL,$page = 1,$per_page = 25) {
        if ($data === '[]') {
            $data = '{}';
        }
        print_r($data);
        $headers = self::_getRequestHeaders();
     
        $url = self::HOST_NAME . $relativeUrl;
        if($method === 'GETONE' && !empty($data)){
            $url .= '/' . $data;
        }
        if ($method === 'GET' && !empty($data)) {
            echo $url .= '?' . http_build_query($data) . '&' . 'page='.$page.'&per_page='.$per_page;
        }
        
        $rest = curl_init();
        curl_setopt($rest, CURLOPT_USERPWD, $apiKey . ":" . $apiKey);
        curl_setopt($rest, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        if ($method === 'POST') {
            $queryOptions = json_encode($data);
            curl_setopt($rest, CURLOPT_POST, 1);
            curl_setopt($rest, CURLOPT_POSTFIELDS, $queryOptions);
        }
        if ($method === 'PUT') {
            $queryOptions = json_encode($data);
            curl_setopt($rest, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($rest, CURLOPT_POSTFIELDS, $queryOptions);
        }
        if ($method === 'DELETE') {
            curl_setopt($rest, CURLOPT_CUSTOMREQUEST, $method);
        }
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($rest);
        $status = curl_getinfo($rest, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($rest, CURLINFO_CONTENT_TYPE);
        if (curl_errno($rest)) {
            throw new CordialException(curl_error($rest), curl_errno($rest));
        }
        curl_close($rest);
        if (strpos($contentType, 'text/html') !== false) {
            throw new CordialException('Bad Request', -1);
        }

        $decoded = json_decode($response, true);

        if (isset($decoded['error'])) {
            throw new CordialException($decoded['message'], isset($decoded['error']) ? $decoded['error'] : 0
            );
        }
        return $decoded;
    }

    public static function _getRequestHeaders() {
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Cache-Control: no-cache';
        return $headers;
    }

}
