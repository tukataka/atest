<?php

namespace App\Exceptions;

class InternalServerErrorException extends ApplicationException
{
    protected $httCode = 500;
}
