<?php
namespace App\Actions;

/**
 * @property \App\Services\ResultService result
 */

class TestAction
{
    public function __construct($result)
    {
        $this->result = $result;
    }

    public function index($data)
    {
        $this->result->success()->withData($data);

        return true;
    }
}