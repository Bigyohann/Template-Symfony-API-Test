<?php

namespace App\EventListener\Exception;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AppExceptionListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof HttpException) {
            return;
        }

        $this->logger->error($exception->getMessage());

        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'status' => 'error',
            'code' => $exception->getStatusCode(),
        ], $exception->getStatusCode());

        $event->setResponse($response);
    }
}
