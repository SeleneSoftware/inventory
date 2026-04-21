<?php

namespace App\Controller;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiStoreController extends AbstractFOSRestController
{
    #[Rest\Get('/api/test')]
    public function test(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Store::class);

        return $this->handleView($this->view(
            $repo->findAll()
        ));
    }
}
