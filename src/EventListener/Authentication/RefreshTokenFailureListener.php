<?php

namespace App\EventListener\Authentication;

use Gesdinet\JWTRefreshTokenBundle\Event\RefreshAuthenticationFailureEvent;

class RefreshTokenFailureListener
{
    public function onRefreshTokenFailure(RefreshAuthenticationFailureEvent $event)
    {

        dd($event);
    }
}
