<?php

declare(strict_types=1);

namespace App\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        // request $request,
        // protected LoggerInterface $logger,
        // protected Filesystem $filesystem
    ) {

    }
    #[Route(path: '/', name: "page_homepage")]
    public function home()
    {
        return $this->render(view: 'index.html.twig');
    }
}