<?php

namespace App\Http\Auth;

use App\Http\AppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AppController
{
    #[Route('/logout', name: 'logout', methods: ['POST'])]
    public function logout(): Response
    {
        $response = new Response();
        $response->headers->clearCookie('BEARER');
        $response->headers->clearCookie('refresh_token');
        $response->setStatusCode(204);

        return $response;
    }
}