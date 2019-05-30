<?php
namespace App\Http\Middleware;

class ApiContentType
{
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next)
    {
        if($request->getContentType() != 'application/json'){
            $this->container->result->fail('invalid_content_type');
            return $this->container->json->result();
        }

        return $next($request, $response);
    }
}
