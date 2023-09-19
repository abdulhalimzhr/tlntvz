<?php

class Request
{
    private $requestData = [];
    private const REQUEST_METHOD = 'REQUEST_METHOD';
    private const PUT_METHOD = 'PUT';
    private const PATCH_METHOD = 'PATCH';
    private const DELETE_METHOD = 'DELETE';

    public function __construct()
    {
        $this->requestData['server']  = $_SERVER;
        $this->requestData['get']     = $_GET;
        $this->requestData['post']    = $_POST;
        $this->requestData['put']     = $this->parsePutData();
        $this->requestData['delete']  = $this->parseDeleteData();
        $this->requestData['patch']   = $this->parsePatchData();
        $this->requestData['headers'] = getallheaders();
        $this->requestData['cookies'] = $_COOKIE;
    }

    public function get($key = null)
    {
        return $this->getValueFromArray($this->requestData['get'], $key);
    }

    public function post($key = null)
    {
        return $this->getValueFromArray($this->requestData['post'], $key);
    }

    public function input($key = null)
    {
        $value = $this->post($key = null);
        if ($value !== null) {
            return $value;
        }
        return $this->get($key);
    }

    public function put($key = null)
    {
        return $this->getValueFromArray($this->requestData['put'], $key);
    }

    public function delete($key = null)
    {
        return $this->getValueFromArray($this->requestData['delete'], $key);
    }

    public function patch($key = null)
    {
        return $this->getValueFromArray($this->requestData['patch'], $key);
    }

    public function server($key = null)
    {
        return $this->getValueFromArray($this->requestData['server'], $key);
    }

    public function header($headerName)
    {
        $headerName = strtolower($headerName);
        return isset($this->requestData['headers'][$headerName]) ? $this->requestData['headers'][$headerName] : null;
    }

    public function cookie($key = null)
    {
        return $this->getValueFromArray($this->requestData['cookies'], $key);
    }

    public function all()
    {
        return $this->requestData;
    }

    private function getValueFromArray($array, $key)
    {
        return isset($array[$key]) ? $array[$key] : $array;
    }

    private function parsePutData()
    {
        if ($this->requestData['server'][self::REQUEST_METHOD] === self::PUT_METHOD) {
            parse_str(file_get_contents("php://input"), $putData);
            return $putData;
        }

        return [];
    }

    private function parseDeleteData()
    {
        if ($this->requestData['server'][self::REQUEST_METHOD] === self::DELETE_METHOD) {
            parse_str(file_get_contents("php://input"), $deleteData);
            return $deleteData;
        }

        return [];
    }

    private function parsePatchData()
    {
        if ($this->requestData['server'][self::REQUEST_METHOD] === self::PATCH_METHOD) {
            parse_str(file_get_contents("php://input"), $patchData);
            return $patchData;
        }

        return [];
    }
}
