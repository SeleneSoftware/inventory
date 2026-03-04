<?php

namespace App\GraphQL\Query;

use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Type]
class StoreQuery
{
    public function __construct(
        private ProductRepository $repo,
    ) {
    }

    #[GQL\Field(type: '[StoreType]')]
    public function stores(): array
    {
        return $repo->findAll();
    }

    #[GQL\Field(type: 'StoreType')]
    public function store(
        #[GQL\Arg] int $id,
    ): ?object {
        return $this->repo->find($id);
    }
}
