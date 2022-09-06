<?php

namespace App\Http;

use App\Domain\User\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AppController extends AbstractController
{
    public LoggerInterface $logger;
    public HubInterface $notifier;
    public SerializerInterface $serializer;
    public ValidatorInterface $validator;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param HubInterface $notifier
     */
    public function setNotifier(HubInterface $notifier): void
    {
        $this->notifier = $notifier;
    }

    /**
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    public function jsonResponse($data, $status = 200, $message = 'ok', $groups = [], $headers = []): JsonResponse
    {
        return $this->json(
            ['data' => $data, 'message' => $message, 'code' => $status],
            $status,
            $headers,
            ['groups' => $groups]
        );
    }
}
