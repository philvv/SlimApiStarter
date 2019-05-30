<?php
namespace App\Http\Controllers;

/**
 * @property \Slim\Http\Request request
 * @property \Slim\Http\Response response
 * @property \Slim\Container container
 * @property \App\Services\ResultService result
 * @property \App\Services\JsonService json
 * @property \App\Services\InputService input
 */

class BaseController
{
    protected $request, $response, $args, $container;

    public function __construct($request, $response, $args, $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->has($property)) {
            return $this->container->{$property};
        }
        return null;
    }

    public function arg($name)
    {
        return $this->args[$name] ?? null;
    }

    public function args()
    {
        return $this->args;
    }
}