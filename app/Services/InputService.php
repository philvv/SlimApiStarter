<?php
namespace App\Services;

/**
 * @property \Slim\Http\Request request
 */

class InputService
{
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function get($name = null, $default = null)
    {
        if(is_null($name)) return $this->request->getQueryParams() ?? array();
        return $this->request->getQueryParam($name, $default);
    }

    public function post($name = null, $default = null)
    {
        if(is_null($name)) return $this->request->getParsedBody() ?? array();
        return $this->request->getParsedBodyParam($name, $default);
    }

    public function only(array $onlys)
    {
        $result = array();
        foreach($this->request->getParams() as $key => $value){
            if(in_array($key, $onlys)) $result[$key] = $value;
        }
        return $result;
    }

    public function expects(array $expects)
    {
        $result = array();
        foreach($expects as $expect){
            $result[$expect] = null;
        }
        foreach($this->request->getParams() as $key => $value){
            if(in_array($key, $expects)) $result[$key] = $value;
        }
        return $result;
    }

    public function oneOf(array $oneofs)
    {
        $found = false;
        foreach($this->request->getParams() as $key => $value){
            if(in_array($key, $oneofs)) {
                $result[$key] = $value;
                $found = true;
                break;
            }
        }
        if($found){
            return $result;
        }
        $result[$oneofs[0]] = null;
        return $result;
    }

    public function all()
    {
        return $this->request->getParams();
    }

}
