<?php

namespace App\Domain\User\Exception;

use App\Exception\AppException;
use Exception;

class UserEmailExistException extends AppException
{
    public function __construct(string $message = '', int $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

