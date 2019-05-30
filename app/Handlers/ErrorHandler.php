<?php
namespace App\Handlers;

/**
 * @property \App\Services\ResultService result
 * @property \App\Services\JsonService json
 * @property \Monolog\Logger log
 */

class ErrorHandler
{
    public function __construct($result, $json, $log, $debug)
    {
        $this->result = $result;
        $this->json = $json;
        $this->log = $log;
        $this->debug = $debug;
    }

    public function __invoke($request, $response, $exception)
    {
        $error = [
            'message' => 'Slim Application Error',
        ];

        $error['exception'] = [];

        do {
            $error['exception'][] = [
                'type' => get_class($exception),
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => explode("\n", $exception->getTraceAsString()),
            ];
        } while ($exception = $exception->getPrevious());

        // Display error
        if($this->debug){
            // Show error
            $this->result->error()->withData($error);
        } else {
            // Log it
            $this->log->error('Slim error', $error);
            $this->result->error();
        }

        return $this->json->result();
    }
}