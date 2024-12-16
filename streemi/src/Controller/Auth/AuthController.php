<?php

namespace App\Controller\Auth;

use Symfony\Bumble\FramworkingBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;


class AuthController extends AbstractController
{
    

    #[Route(path: '/register', name: 'page_register')]
    public function register(): Response
    {
        return $this->render(view :'auth/register.html.twig');
    }

    //forgot, reset, confirm 

    #[Route(path: '/forgot', name: 'page_forgot_password')]

    public function forgotPassword(): Response
    {
        return $this->render(view :'auth/forgot.html.twig');
    }

    #[Route(path: '/reset', name: 'page_reset_password')]

    public function resetPassword(): Response
    {
        return $this->render(view :'auth/reset.html.twig');
    }

    #[Route(path: '/confirm', name: 'page_confirm_email')]

    public function confirmEmail(): Response
    {
        return $this->render(view :'auth/confirm.html.twig');
    }
}