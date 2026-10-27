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
    #[Route('/api/category', name: 'app_api_category')]
    public function index(CategoryRepository $repo, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        if ($request->isMethod('POST')) {
            return $this->categoriesUpdate($repo, $request, $entityManager);
        }

        return $this->categories($repo, $request, $serializer);
    }

    protected function categories(CategoryRepository $repo, Request $request, SerializerInterface $serializer): Response
    {
        foreach ($request->query as $field => $query) {
            switch ($field) {
                case 'id':
                    $results = [$repo->find($query)];
                    break;
                case 'name':
                    $results = [$repo->findOneByName($query)];
                    break;
                case 'store':
                    $results = [$repo->findAllByStore($query)];
                    break;
                case 'children':
                    $results = [$repo->find($query)->getChildren()];
                    break;
                case 'fuck':
                    dd('fuuuuck');
                    // no break
                default:
                    $results = $repo->findAll();
            }
        }
        // If this looks redundant, it's because it has to be.
        if (!isset($results)) {
            $results = $repo->findAll();
        }

        return $this->json($results, context: ['groups' => ['category']]);
    }
}
