<?php
namespace App\Handlers;

/**
 * @property \App\Services\ResultService result
 * @property \App\Services\JsonService json
 */

class NotFoundHandler
{
    public function __construct($result, $json)
    {
        $this->result = $result;
        $this->json = $json;
    }

    public function __invoke($request, $response)
    {
        $this->result->fail('not_found');

        return $this->json->result();
    }
}
