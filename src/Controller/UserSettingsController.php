<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPermissionsType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class UserSettingsController extends AbstractController
{
    #[Route('/settings/user/permissions', name: 'app_user_permissions')]
    #[IsGranted('admin')]
    public function indexPermissions(UserRepository $repo): Response
    {
        return $this->render('user_settings/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route('/settings/user/permissions/{id}', name: 'app_user_permissions_edit')]
    #[IsGranted('admin')]
    public function editPermissions(User $id, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserPermissionsType::class, $id->getPermissions()->getMode());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = [];

            foreach ($form as $name => $field) {
                $value = $field->getData();
                $data[$name] = $value;
            }
            $permission = $id->getPermissions();
            $perms = array_replace_recursive($permission->getMode(), $data);

            $permission->setMode($perms);

            $em->persist($permission);
            $em->flush();

            return $this->redirectToRoute('app_user_permissions');
        }

        return $this->render('user_settings/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $id,
        ]);
    }

    #[Route('/settings/user/{id}/delete', name: 'app_user_permissions_delete')]
    #[IsGranted('admin')]
    public function delete(User $id): Response
    {
        return $this->render('user_settings/index.html.twig', [
            'controller_name' => 'UserSettingsController',
        ]);
    }
}
