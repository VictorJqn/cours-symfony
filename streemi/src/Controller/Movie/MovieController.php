<?php

namespace App\Controller\Movie;

use App\Entity\Media;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;


class MovieController extends AbstractController
{
    #[Route(path: '/', name: 'page_index')]
    public function index(): Response
    {
        return $this->render(view :'index.html.twig');
    }

    #[Route(path: '/detail/serie', name: 'page_detail_serie')]
    public function detailSerie(): Response
    {
        return $this->render(view :'movie/detail_serie.html.twig');
    }

    #[Route(path: '/detail/{id}', name: 'page_detail')]

    public function detail(Media $media): Response
    {
        return $this->render(view :'movie/detail.html.twig', parameters: [
            'media' => $media,
        ]);
    }

    // #[Route(path: '/discover', name: 'page_discover')]

    // public function discover(): Response
    // {
    //     return $this->render(view :'movie/discover.html.twig');
    // }

    // #[Route(path: '/lists', name: 'page_lists')]

    public function lists(): Response
    {
        return $this->render(view :'movie/lists.html.twig');
    }


}