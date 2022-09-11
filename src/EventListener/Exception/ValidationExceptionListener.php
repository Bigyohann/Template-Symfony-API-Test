<?php

namespace App\EventListener\Exception;

use App\Exception\Api\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationExceptionListener
{
    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof ValidationException) {
            return;
        }

        $errors = [];

        if ($exception->getErrors() instanceof ConstraintViolationList) {
            foreach ($exception->getErrors() as $error) {
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'error' => $errors,
            'code' => Response::HTTP_BAD_REQUEST,
        ], Response::HTTP_BAD_REQUEST);

        $event->setResponse($response);
    }
}
