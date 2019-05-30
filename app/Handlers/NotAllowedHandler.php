<?php
namespace App\Handlers;

/**
 * @property \App\Services\ResultService result
 * @property \App\Services\JsonService json
 */

class NotAllowedHandler
{
    public function __construct($result, $json)
    {
        $this->result = $result;
        $this->json = $json;
    }

    public function __invoke($request, $response, $methods)
    {
        $this->result->fail('method_not_allowed', implode(', ', $methods));

        return $this->json->result();
    }
}
