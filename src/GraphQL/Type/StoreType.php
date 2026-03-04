<?php

namespace App\GraphQL\Type;

use App\Entity\Store;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Type]
class StoreType
{
    public function __construct(
        private Store $store,
    ) {
    }

    #[GQL\Field]
    public function id(): ?int
    {
        return $this->store->getId();
    }

    #[GQL\Field]
    public function name(): ?string
    {
        return $this->store->getName();

    }
}
