<?php

namespace App\Http;

use App\Domain\User\Utils\RolesEnum;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AppController extends AbstractController
{
    public LoggerInterface $logger;
    private readonly Security $security;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param $data
     * @param int $status
     * @param string $message
     * @param array $groups
     * @param array $headers
     * @return JsonResponse
     */
    public function jsonResponse($data, int $status = 200, string $message = 'ok', array $groups = ['user:read'], array $headers = []): JsonResponse
    {
        if ($this->getUser()) {
            if (in_array(RolesEnum::ADMIN->value, $this->getUser()->getRoles())) {
                $groups[] = 'admin:read';
            }

            // Add all default groups here with their roles
        }
        return $this->json(
            ['data' => $data, 'message' => $message, 'code' => $status],
            $status,
            $headers,
            ['groups' => $groups]
        );
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->getSecurity()->getUser();
    }

    /**
     * @return Security
     */
    private function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * @param Security $security
     */
    public function setSecurity(Security $security): void
    {
        $this->security = $security;
    }
}
