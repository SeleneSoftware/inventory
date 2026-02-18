<?php

namespace App\Helpers;

trait RepositorySlugTrait
{
    public function findOneBySlug($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.slug = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
