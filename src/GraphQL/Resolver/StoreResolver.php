<?php

namespace App\GraphQL\Resolver;

use App\Repository\StoreRepository;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Provider]
class StoreResolver
{
    public function __construct(
        private StoreRepository $storeRepository,
    ) {
    }

    #[GQL\Query(type: 'Store', name: 'store')]
    public function getStore(int $id): ?object
    {
        return $this->storeRepository->find($id);
    }

    #[GQL\Query(type: '[Store!]!', name: 'stores')]
    public function getStores(): array
    {
        return $this->storeRepository->findAll();
    }
}
