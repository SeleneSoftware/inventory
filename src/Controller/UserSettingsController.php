<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class UserSettingsController extends AbstractController
{
    #[Route('/settings/user', name: 'app_user_settings')]
    #[IsGranted('admin')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('user_settings/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route('/settings/user/{id}', name: 'app_user_settings_edit')]
    #[IsGranted('admin')]
    public function edit(User $id, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $id);

        return $this->render('user_settings/edit.html.twig', [
            'form' => $form,
            'user' => $id,
        ]);
    }

    #[Route('/settings/user/{id}/delete', name: 'app_user_settings_delete')]
    #[IsGranted('admin')]
    public function delete(User $id): Response
    {
        return $this->render('user_settings/index.html.twig', [
            'controller_name' => 'UserSettingsController',
        ]);
    }
}
