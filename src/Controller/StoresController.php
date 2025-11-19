<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StoresController extends AbstractController
{
    #[Route('/stores', name: 'app_stores')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Store::class);

        return $this->render('stores/index.html.twig', [
            'stores' => $repo->findAll(),
        ]);
    }

    #[Route('/stores/new', name: 'app_stores_new')]
    public function newStore(EntityManagerInterface $entityManager, Request $request): Response
    {
        $store = new Store();
        $store->setCode('Not implemented yet');
        $form = $this->createForm(StoreType::class, $store);

        $form->handleRequest($request);

        // dd($store);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($store);
            $entityManager->persist($store);
            $entityManager->flush();

            return $this->redirectToRoute('app_stores');
        }

        return $this->render('stores/edit.html.twig', [
            'page_type' => 'New',
            'form' => $form,
        ]);
    }

    #[Route('/stores/edit/{id}', name: 'app_stores_edit')]
    public function editStore(Store $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(StoreType::class, $id);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($id);
            $entityManager->flush();

            return $this->redirectToRoute('app_stores');
        }

        return $this->render('stores/edit.html.twig', [
            'page_type' => 'Edit '.$id->getName(),
            'form' => $form,
        ]);
    }

    #[Route('/stores/deactivate/{id}', name: 'app_stores_deactivate')]
    public function deactivateStore(Store $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $id->setStatus(false);

        $entityManager->persist($id);
        $entityManager->flush();

        return $this->redirectToRoute('app_stores');
    }

    #[Route('/stores/activate/{id}', name: 'app_stores_activate')]
    public function activateStore(Store $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $id->setStatus(true);

        $entityManager->persist($id);
        $entityManager->flush();

        return $this->redirectToRoute('app_stores');
    }
}
