<?php
namespace App\Services;

use App\Validation\Rules;

class ValidatorService
{
    protected $errors = array();
    protected $rules = array();
    protected $validators = array();

    public function __construct()
    {
        $this->validators = Rules::get();
    }

    public function use($validator_name)
    {
        if(!isset($this->validators[$validator_name])){
            throw new \Exception("Validator service: '" . $validator_name . "' does not exist");
        }
        $this->rules = $this->validators[$validator_name];
    }

    public function isValid($data)
    {
        foreach ($data as $key => $value) {
            if(isset($this->rules[$key])){
                $this->processRule($key, $value);
            }
        }

        return ! $this->hasErrors();
    }

    public function processRule($key, $value)
    {
        try {
            $validator = $this->rules[$key];
            $validator->setName($key);
            $validator->assert($value);
        } catch (\InvalidArgumentException $ex) {
            $ex->findMessages([
                'in' => '{{name}} must be a valid option: {{haystack}}'
            ]);
            $this->errors[$key] = $ex->getMessages();
        }
    }

    public function hasRequired(array $required, array $data)
    {
        foreach($required as $key){
            if(!array_key_exists($key, $data)){
                $this->errors[$key] = $key . ' is required';
            }
        }

        return ! $this->hasErrors();
    }

    public function hasOneOf(array $one_of, array $data)
    {
        if(count($one_of) < 2){
            throw new \Exception("Validator service: 'hasOneOf' method requires at least 2 elements");
        }

        $found = false;

        foreach($one_of as $key){
            if(array_key_exists($key, $data)){
                return true;
            }
        }

        if(!$found){
            foreach($one_of as $key){
                $this->errors[$key] = $key . " required if " . $this->getMissingKeys($key, $one_of) . " missing";
            }
        }

        return ! $this->hasErrors();
    }

    public function getMissingKeys($key, array $list)
    {
        $pos = array_search($key, $list);
        unset($list[$pos]);

        if(count($list) == 1){
            reset($list);
            return current($list);
        }

        $string = "";

        foreach($list as $key){
            if ($key === end($list)) {
                $string .= ' or ' . $key;
            } elseif ($key === reset($list)) {
                $string .= $key;
            } else {
                $string .= ', ' . $key;
            }
        }

        return $string;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0 ? true : false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
