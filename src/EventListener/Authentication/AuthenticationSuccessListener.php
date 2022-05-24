<?php

namespace App\EventListener\Authentication;

use App\Domain\User\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        /** @var User $user */
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $data = [
            'data' => [
                'roles' => $user->getRoles(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
            ],
            'message' => 'logged-in',
            'code' => 200,
        ];


        $event->setData($data);
    }

}
