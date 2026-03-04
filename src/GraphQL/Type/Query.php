<?php

namespace App\GraphQL\Type;

use App\GraphQL\Query\StoreQuery;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Type]
class Query extends StoreQuery
{
}
