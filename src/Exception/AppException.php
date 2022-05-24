<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

abstract class AppException extends HttpException
{
    public function __construct($message = "", int $code = 500, Throwable $previous = null)
    {
        parent::__construct($code, $message, $previous);
    }
}
