<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Form\ProductAttributeType;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class ProductsController extends AbstractController
{
    #[Route('/dashboard/products', name: 'app_products')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Product::class);

        return $this->render('products/index.html.twig', [
            'products' => $repo->findAll(),
        ]);
    }

    #[Route('/dashboard/products/new', name: 'app_products_new')]
    public function newProduct(EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            dd($form->get('variantsAttr')->getData());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products');
        }

        return $this->render('products/edit.html.twig', [
            'page_type' => 'New',
            'form' => $form,
            'product' => $product,
        ]);
    }

    #[Route('/dashboard/products/edit/{id}', name: 'app_products_edit')]
    public function editProduct(EntityManagerInterface $entityManager, Request $request, Product $id): Response
    {
        $product = $id;
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products');
        }

        return $this->render('products/edit.html.twig', [
            'page_type' => 'New',
            'form' => $form,
            'product' => $product,
        ]);
    }

    #[Route('/dashboard/products/deactivate/{id}', name: 'app_products_deactivate')]
    public function deactivateProduct(Product $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $id->setStatus(false);

        $entityManager->persist($id);
        $entityManager->flush();

        return $this->redirectToRoute('app_products');
    }

    #[Route('/dashboard/products/activate/{id}', name: 'app_products_activate')]
    public function activateProduct(Product $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $id->setStatus(true);

        $entityManager->persist($id);
        $entityManager->flush();

        return $this->redirectToRoute('app_products');
    }

    #[Route('/dashboard/products/attributes', name: 'app_products_attributes')]
    public function productAttributes(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(ProductAttribute::class);

        return $this->render('products/attributes/index.html.twig', [
            'attributes' => $repo->findAll(),
        ]);
    }

    #[Route('/dashboard/products/attributes/new', name: 'app_products_attributes_new')]
    public function newProductAttribute(EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = new ProductAttribute();
        $form = $this->createForm(ProductAttributeType::class, $product);

        $form->handleRequest($request);

        // dd($product);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($product);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products_attributes');
        }

        return $this->render('products/attributes/edit.html.twig', [
            'page_type' => 'New',
            'form' => $form,
        ]);
    }

    #[Route('/dashboard/products/attributes/edit/{id}', name: 'app_products_attributes_edit')]
    public function editProductAttribute(ProductAttribute $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = $id;
        $form = $this->createForm(ProductAttributeType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products_attributes');
        }

        return $this->render('products/attributes/edit.html.twig', [
            'page_type' => 'Edit',
            'form' => $form,
        ]);
    }
}
