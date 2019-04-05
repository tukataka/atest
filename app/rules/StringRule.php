<?php

namespace App\Rules;

use Rakit\Validation\Rule;

class StringRule extends Rule
{
    protected $message = "The :attribute must be string";

    public function check($value): bool
    {
        return is_string($value);
    }
}
