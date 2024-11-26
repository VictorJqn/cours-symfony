<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route(path: '/category/{id}', name: 'page_category')]
    public function category(string $id, CategoryRepository $categoryRepository
    ): Response
    {
        $category = $categoryRepository->find($id);
        return $this->render(view: 'movie/category.html.twig', parameters: [
            'category' => $category,
        ]);
    }

    #[Route(path: '/discover', name: 'page_discover')]

    public function discover(
        CategoryRepository $categoryRepository
    ): Response {
    $categories = $categoryRepository->findAll();

    return $this->render(view: 'movie/discover.html.twig', parameters: [
        'categories' => $categories,
    ]);
    }
}