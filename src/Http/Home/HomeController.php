<?php

namespace App\Http\Home;

use App\Http\AppController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AppController
{
    /**
     * @return JsonResponse
     */
    #[Route(path:'/', methods:['GET'])]
    public function home()
    {
        return $this->jsonResponse(
            [
                'description' => 'This is an API to handle Coproprietors',
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
