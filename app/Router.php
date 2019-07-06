<?php

class Router
{
    private $method;
    private $uri;
    private $allowedMethods = ['get'];
    private $register = [];

    public function __construct($method, $uri)
    {
        $this->method = strtolower($method);
        $this->uri = strtolower($uri);
    }

    public function __call($name, $params)
    {
        list($route, $method) = $params;

        if (in_array($name, $this->allowedMethods)) {
            $this->register[$name][$route] = $method;
        }
    }

    public function resolve()
    {
        if (isset($this->register[$this->method])) {
            if (isset($this->register[$this->method][$this->uri])) {
                return $this->register[$this->method][$this->uri]();
            } else {
                return $this->handlerNotAllowed();
            }
        } else {
            return $this->handlerNotFound();
        }
    }

    private function handlerNotAllowed()
    {
        return $this->handlerDefault();
    }

    private function handlerNotFound()
    {
        return $this->handlerDefault();
    }

    private function handlerDefault()
    {
        return 'Page not found';
    }

}
