<?php

namespace App\Exceptions;

class NotFoundException extends ApplicationException
{
    protected $httCode = 404;
}
