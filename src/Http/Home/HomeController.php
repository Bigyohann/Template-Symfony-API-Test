<?php

namespace App\Http\Home;

use App\Http\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AppController
{
    /**
     * @return JsonResponse
     */
    #[Route(path:'/', methods:['GET'])]
    public function home(): JsonResponse
    {
        return $this->jsonResponse(
            [
                'description' => 'Try to create a basic template with auto DTO parsing',
                'documentation' => 'Not available yet',
                'version' => '0.0.1',
                'author' => 'Yohann BIGLIA',
                'contact' => 'contact@yohannbiglia.fr',
            ],
            200,
            'ok'
        );
    }
}
