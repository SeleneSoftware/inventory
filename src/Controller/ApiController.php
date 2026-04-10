<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiController extends AbstractController
{
    #[Route('/api/stores', name: 'app_api_stores')]
    public function stores(StoreRepository $repo, Request $request): Response
    {
        foreach ($request->query as $field => $query) {
            switch ($field) {
                case 'id':
                    $results = [$repo->find($query)];
                    break;
                case 'name':
                    $results = [$repo->findOneByName($query)];
                    break;
                default:
                    $results = $repo->findAll();
            }
        }

        $array = [];
        foreach ($results as $store) {
            $categories = [];
            if (null === $store) {
                return $this->json(['error' => 'Store Not Found']);
            }
            foreach ($store->getCategories() as $cat) {
                $categories[] = [
                    'name' => $cat->getName(),
                    'apiLink' => 'TBA: '.$cat->getName(),
                ];
            }
            $array[] = [
                'id' => $store->getId(),
                'name' => $store->getName(),
                'link' => $store->getLink(),
                'categories' => $categories,
            ];
        }

        return $this->json($array);
    }
}
