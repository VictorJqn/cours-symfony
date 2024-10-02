<?php

declare (strict_types=1);

namespace App\Controller;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: '/')]
    public function home()
    {
        return $this->render(view :'auth/login.html.twig');
    }
}