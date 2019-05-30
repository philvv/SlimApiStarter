<?php
namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class YesOrNo extends AbstractRule
{
    public function validate($input)
    {
        return (strtolower($input) == 'yes' || strtolower($input) == 'no') ? true : false;
    }
}
