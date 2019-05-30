<?php
namespace App\Services;

/**
 * @property \Slim\Http\Response response
 * @property \App\Services\ResultService result
 */

class JsonService
{
    public function __construct($response, $result)
    {
        $this->response = $response;
        $this->result = $result;
    }

    public function result()
    {
        return $this->response->withJson($this->result->get(), $this->result->getStatus());
    }
}
