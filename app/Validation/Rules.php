<?php
namespace App\Validation;

use Respect\Validation\Validator as V;

class Rules
{
    public static function get()
    {
        V::with('App\\Validation\\Rules\\');

        return [
            // Rules
        ];
    }
}