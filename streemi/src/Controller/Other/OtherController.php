<?php

namespace App\Controller\Other;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;


class OtherController extends AbstractController
{
    #[Route(path: '/abonnements', name: 'page_abonnements')]
    public function abonnements(): Response
    {
        return $this->render(view :'other/abonnements.html.twig');
    }

    #[Route(path: '/upload', name: 'page_upload')]
    public function upload(): Response
    {
        return $this->render(view :'other/upload.html.twig');
    }
}