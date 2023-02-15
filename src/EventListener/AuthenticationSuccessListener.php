<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $event->setData([
            'token' => $event->getData()['token'],
            'role' => $event->getUser()->getRoles()[0]
        ]);
    }
}