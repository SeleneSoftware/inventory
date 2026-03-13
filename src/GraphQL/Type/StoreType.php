<?php

namespace App\GraphQL\Type;

use App\Entity\Store;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Type(name: 'Store')]
class StoreType
{
    #[GQL\Field(type: 'Int!')]
    public function id(Store $store): ?int
    {
        return $store->getId();
    }

    #[GQL\Field(type: 'String!')]
    public function name(Store $store): ?string
    {
        return $store->getName();
    }

    #[GQL\Field(type: 'String')]
    public function link(Store $store): ?string
    {
        return $store->getLink();
    }

    #[GQL\Field(type: 'String')]
    public function code(Store $store): ?string
    {
        return $store->getCode();
    }

    #[GQL\Field(type: 'Boolean')]
    public function status(Store $store): ?bool
    {
        return $store->isStatus();
    }

    #[GQL\Field(type: '[Category]')]
    public function categories(Store $store)
    {
        return $store->getCategories();
    }
}
