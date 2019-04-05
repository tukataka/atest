<?php

namespace App\Exceptions;

use Exception;
use Throwable;

abstract class ApplicationException extends Exception
{
    private $errors = [];

    protected $httCode;

    public function __construct(array $errors = [], Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct('', 0, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getHttpCode(): int
    {
        return $this->httCode;
    }
}
