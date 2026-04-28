<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ApiCategoriesController extends AbstractController
{
    #[Route('/api/categories', name: 'app_api_categories')]
    public function index(CategoryRepository $repo, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        if ($request->isMethod('POST')) {
            return $this->categoriesUpdate($repo, $request, $entityManager);
        }

        return $this->categories($repo, $request, $serializer);
    }

    protected function categories(CategoryRepository $repo, Request $request, SerializerInterface $serializer): Response
    {
        return $this->json($repo->findAll(), context: ['groups' => ['category']]);
    }
}
