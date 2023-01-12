<?php

namespace App\Generator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;

class SkuGenerator extends AbstractIdGenerator
{
    public function generate(EntityManagerInterface $em, $entity)
    {
        $sequenceId = $entity->getId();

        $query = $em->createQuery('UPDATE Product i SET i.sku = i.sku + 1 WHERE i.id = :id');
        $query->setParameter('id', $sequenceId);
        $query->execute();

        $increment = $em->createQuery('SELECT i.sku FROM Product i WHERE i.id = :id');
        $increment->setParameter('id', $sequenceId);

        return "{$entity->getSupplier()->getPrefix()}.{$increment->getSingleResult()['sku']}";
    }
}
