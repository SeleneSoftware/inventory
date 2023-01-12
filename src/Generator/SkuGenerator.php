<?php

namespace App\Generator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;

class SkuGenerator extends AbstractIdGenerator
{
    public function generate(EntityManagerInterface $em, $entity)
    {
        $sequenceId = $entity->getId();

        var_dump($entity->getId());
        exit;

        return "{$entity->getSupplier()->getPrefix()}.{$increment->getSingleResult()['sku']}";
    }
}
