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
use Symfony\Component\String\Slugger\AsciiSlugger;

#[IsGranted('ROLE_USER')]
final class ProductsController extends AbstractController
{
    #[Route('/dashboard/products', name: 'app_products')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Product::class);
        // dd($repo->findAll());

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

            if (null === $product->getSKU()) {
                $product->generateSku();
                // dd($product);
            }

            if (Product::TYPE_PARENT === $product->getType()) {
                $slugger = new AsciiSlugger();
                $attributes = $form->get('variantsAttr')->getData();

                $products = [];

                $combinations = $this->generateCombinations($attributes);

                foreach ($combinations as $combination) {
                    $vProduct = new Product();

                    // Build product name
                    $nameParts = [];

                    foreach ($combination as $item) {
                        $attribute = $item['attribute'];
                        $value = $item['value'];

                        $vProduct->addAttribute($attribute, $value);
                        $nameParts[] = $value;
                    }

                    $vProduct->setName(implode('-', $nameParts))
                             ->setType(Product::TYPE_VARIANT)
                         ->setCategory($product->getCategory())
                    ;

                    // $products[] = $product;
                    $entityManager->persist($vProduct);
                    $entityManager->flush();
                }
            }
            if (Product::TYPE_SINGLE === $product->getType()) {
                $entityManager->persist($product);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_products');
        }

        return $this->render('products/edit.html.twig', [
            'page_type' => 'New',
            'form' => $form,
            'product' => $product,
        ]);
    }

    protected function generateCombinations(array $attributes): array
    {
        $result = [[]];

        foreach ($attributes as $attribute) {
            $new = [];

            foreach ($result as $combo) {
                foreach ($attribute['values'] as $value) {
                    $newCombo = $combo;
                    $newCombo[] = [
                        'attribute' => $attribute['variant'],
                        'value' => $value,
                    ];
                    $new[] = $newCombo;
                }
            }

            $result = $new;
        }

        return $result;
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
