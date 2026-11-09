<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InstallerController extends AbstractController
{
    #[Route('/installer', name: 'app_installer')]
    public function index(): Response
    {
        // Just in case someone wants to try to hack it.
        $installedFile = $this->getParameter('kernel.project_dir').'/var/installed.lock';

        // Application is already installed
        if (file_exists($installedFile)) {
            $url = $this->generateUrl('app_default');

            return new RedirectResponse($url);
        }

        // The installation lock file.  Without this file, the system will run the installer.
        file_put_contents(
            $this->getParameter('kernel.project_dir').'/var/installed.lock',
            date(DATE_ATOM)
        );

        return $this->render('installer/index.html.twig', [
            'controller_name' => 'InstallerController',
        ]);
    }

    #[Route('/installer/admin', name: 'app_installer_admin')]
    public function admin(): Response
    {

        return $this->render('installer/index.html.twig', [
            'controller_name' => 'InstallerController',
        ]);
    }
}
