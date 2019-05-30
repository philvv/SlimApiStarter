<?php
namespace App\Http\Controllers;

/**
 * @property \App\Actions\TestAction test_action
 */

class TestController extends BaseController
{
    public function index()
    {
        $this->test_action->index($this->input->all());

        return $this->json->result();
    }
}