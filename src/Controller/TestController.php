<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    #[Route('/test', name: 'app_lucky_number')]
    public function test(): Response
    {
        return new Response(
            'TEST'
        );
    }
}