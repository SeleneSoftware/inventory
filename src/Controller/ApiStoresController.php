<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ApiStoresController extends AbstractController
{
    #[Route('/api/stores', name: 'app_api_stores')]
    public function index(StoreRepository $repo, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        if ($request->isMethod('POST')) {
            return $this->storesUpdate($repo, $request, $entityManager);
        }

        return $this->stores2($repo, $request, $serializer);
    }

    public function stores2(StoreRepository $repo, Request $request, SerializerInterface $serializer): Response
    {
        return $this->json($repo->findAll(), context: ['groups' => ['store']]);
    }

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
        // If this looks redundant, it's because it has to be.
        if (!isset($results)) {
            $results = $repo->findAll();
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

    public function storesUpdate(StoreRepository $repo, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$request->query->get('id')) {
            return $this->json(['error' => 'Nothing']);
        }

        $store = $repo->find($request->query->get('id'));
        $categories = [];
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

        return $this->json($array);
    }
}
