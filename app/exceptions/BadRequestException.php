<?php

namespace App\Exceptions;

class BadRequestException extends ApplicationException
{
    protected $httCode = 400;
}
