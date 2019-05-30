<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class YesOrNoException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT  => [
            self::STANDARD => "{{name}} must be 'yes' or 'no'",
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => "{{name}} must not be 'yes' or 'no'"
        ],
    ];
}
