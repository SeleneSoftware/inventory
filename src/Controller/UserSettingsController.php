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
    public function edit(User $id, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserPermissionsType::class, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = [];

            foreach ($form as $name => $field) {
                $value = $field->getData();

                if (is_array($value)) {
                    $data[$name] = array_fill_keys($value, true);
                } else {
                    $data[$name] = $value;
                }
                // unset($data['email']);
            }
            $permission = $id->getPermissions();
            $perms = array_replace_recursive($permission->getMode(), $data);

            $permission->setMode($perms);

            $em->persist($permission);
            dd($permission->getMode());

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('user_settings/edit.html.twig', [
            'form' => $form->createView(),
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
