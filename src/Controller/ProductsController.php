<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Product::class);

        return $this->render('products/index.html.twig', [
            'products' => $repo->findAll(),
        ]);
    }

    #[Route('/products/new', name: 'app_products_new')]
    public function newProduct(EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        // dd($product);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($product);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products');
        }

        return $this->render('products/edit.html.twig', [
            'page_type' => 'New',
            'form' => $form,
        ]);
    }

    #[Route('/products/deactivate/{id}', name: 'app_products_deactivate')]
    public function deactivateProduct(Product $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $id->setStatus(false);

        $entityManager->persist($id);
        $entityManager->flush();

        return $this->redirectToRoute('app_products');
    }

    #[Route('/products/activate/{id}', name: 'app_products_activate')]
    public function activateProduct(Product $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $id->setStatus(true);

        $entityManager->persist($id);
        $entityManager->flush();

        return $this->redirectToRoute('app_products');
    }
}
