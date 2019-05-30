<?php
namespace App\Services;

class ResultService
{
    // Result constants
    const SUCCESS               = [200, "success"];
    const FAIL                  = [422, "fail"];
    const ERROR                 = [500, "error"];
    const MULTI_STATUS          = [207, "multi_status"];

    private $results = array();
    private $results_data = array();
    private $multi_mode = false;
    private $index = 0;

    public function __construct($results_data)
    {
        $this->results_data = $results_data;
    }

    public function success($code = null, $vars = array())
    {
        $this->result(self::SUCCESS[1], $code, $vars);
        return $this;
    }

    public function fail($code = null, $vars = array())
    {
        $this->result(self::FAIL[1], $code, $vars);
        return $this;
    }

    public function error($code = null, $vars = array())
    {
        $this->result(self::ERROR[1], $code, $vars);
        return $this;
    }

    private function result($result, $code, $vars = array())
    {
        if(!is_null($code)){
            if(!isset($this->results_data[$code])) {
                throw new \Exception("Result service: '" . $code . "' is not a valid result code");
            }

            if(!is_numeric($this->results_data[$code][0])) {
                throw new \Exception('Result service: ' . $this->results_data[$code][0] . ' is not a valid status');
            }

            $status = $this->results_data[$code][0];
            $message = $this->results_data[$code][1];

        } else {
            $status = constant('self::' . strtoupper($result))[0];
            $code = constant('self::' . strtoupper($result))[1];
            $message = ucfirst(constant('self::' . strtoupper($result))[1]);
        }


        if($this->multi_mode){
            $this->index++;
        }

        $this->results[$this->index]['result'] = $result;
        $this->results[$this->index]['status'] = $status;
        $this->results[$this->index]['code'] = strtoupper($code);
        $this->results[$this->index]['message'] = empty($vars) ? $message : vsprintf($message, $vars);

        return $this;
    }

    public function withData(array $data)
    {
        $this->results[$this->index]['data'] = $data;
        return $this;
    }

    public function withErrors(array $errors)
    {
        $this->results[$this->index]['data'] = $errors;
        return $this;
    }

    public function multi()
    {
        $this->results = array();
        $this->multi_mode = true;
    }

    public function get()
    {
        if(empty($this->results)) {
            throw new \Exception('Result service: object has not been created');
        }

        if (!$this->multi_mode){
            $result = [
                'result' => $this->results[$this->index]['result'],
                'status' => $this->results[$this->index]['status'],
                'code' => $this->results[$this->index]['code'],
                'message' => $this->results[$this->index]['message'],
                'data' => $this->results[$this->index]['data'] ?? array()
            ];
        } else {
            $multi_results = array();

            foreach($this->results as $result){
                $multi_results[] = [
                    'result' => $result['result'],
                    'status' => $result['status'],
                    'code' => $result['code'],
                    'message' => $result['message'],
                    'data' => $result['data'] ?? array()
                ];
            }

            $result = [
                'result' => self::MULTI_STATUS[1],
                'status' => self::MULTI_STATUS[0],
                'code' => strtoupper(self::MULTI_STATUS[1]),
                'message' => ucfirst(str_replace('_', ' ', self::MULTI_STATUS[1])),
                'data' => $multi_results
            ];
        }

        return $result;
    }

    public function getResult()
    {
        return $this->multi_mode ? self::MULTI_STATUS[1] : $this->results[$this->index]['result'];
    }

    public function getStatus()
    {
        return $this->multi_mode ? self::MULTI_STATUS[0] : $this->results[$this->index]['status'];
    }

    public function getCode()
    {
        return $this->multi_mode ? self::MULTI_STATUS[1] : $this->results[$this->index]['code'];
    }
}
