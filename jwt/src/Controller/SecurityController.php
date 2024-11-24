<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/login_check', name: 'app_security')]
    public function loginCheck()
    {
        
    }
    #[Route('/api/test', name: 'app_test')]
    public function apiTest() : Response
    {
        return new Response("Vous etes connnecte");
    }
}
