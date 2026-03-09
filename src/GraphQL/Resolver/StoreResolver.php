<?php

namespace App\GraphQL\Resolver;

use App\Repository\StoreRepository;

class StoreResolver
{
    public function __construct(
        private StoreRepository $storeRepository,
    ) {
    }

    public function store(int $id)
    {
        return $this->storeRepository->find($id);
    }

    public function stores()
    {
        return $this->storeRepository->findAll();
    }
}
