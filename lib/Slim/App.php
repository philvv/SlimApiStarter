<?php
namespace Lib\Slim;

use \Slim\App as Slim;

class App extends Slim
{
    public function get($pattern, $callable, $func = null)
    {
        return $this->route(['GET'], $pattern, $callable, $func);
    }

    public function post($pattern, $callable, $func = null)
    {
        return $this->route(['POST'], $pattern, $callable, $func);
    }

    public function put($pattern, $callable, $func = null)
    {
        return $this->route(['PUT'], $pattern, $callable, $func);
    }

    public function patch($pattern, $callable, $func = null)
    {
        return $this->route(['PATCH'], $pattern, $callable, $func);
    }

    public function delete($pattern, $callable, $func = null)
    {
        return $this->route(['DELETE'], $pattern, $callable, $func);
    }

    public function options($pattern, $callable, $func = null)
    {
        return $this->route(['OPTIONS'], $pattern, $callable, $func);
    }

    public function any($pattern, $callable, $func = null)
    {
        return $this->route(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], $pattern, $callable, $func);
    }

    public function route(array $methods, $pattern, $controller, $func)
    {
        return $this->map($methods, $pattern, function($request, $response, $args) use ($controller, $func) {

            $callable = new $controller($request, $response, $args, $this);

            $call = call_user_func_array([$callable, $func], $args);

            if(!$call){
                throw new \Exception("Method '". $func . "' not found in Class '". $controller . "'");
            }

            return $call;
        });
    }
}
