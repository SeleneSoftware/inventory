<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StoresController extends AbstractController
{
    #[Route('/stores', name: 'app_stores')]
    public function index(): Response
    {
        return $this->render('stores/index.html.twig', [
            'controller_name' => 'StoresController',
        ]);
    }
}
