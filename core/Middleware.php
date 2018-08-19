<?php

namespace Core;

abstract class Middleware
{
    /**
     * @var Request
     */
    public $request;
    /**
     * @var Response
     */
    public $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function next()
    {
        return [$this->request, $this->response];
    }

    abstract public function run();
}