<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class CategoriesController extends AbstractController
{
    #[Route('/dashboard/categories', name: 'app_categories')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Category::class);

        return $this->render('categories/index.html.twig', [
            'categories' => $repo->findAll(),
        ]);
    }

    #[Route('/dashboard/categories/new', name: 'app_categories_new')]
    public function newCategory(EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_categories');
        }

        return $this->render('categories/edit.html.twig', [
            'page_type' => 'New',
            'form' => $form,
            'category' => $category,
        ]);
    }
}
