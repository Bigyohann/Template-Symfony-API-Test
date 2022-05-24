<?php

namespace App\Exception\Api;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends \Exception
{

    private array|ConstraintViolationList $errors;

    /**
     * @param string $message
     * @param ConstraintViolationList|array $errors
     */
    public function __construct(string $message, $errors)
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    /**
     * @return ConstraintViolationList|array
     */
    public function getErrors(): ConstraintViolationList|array
    {
        return $this->errors;
    }
}
