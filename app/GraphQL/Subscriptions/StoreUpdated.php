<?php

namespace App\GraphQL\Subscriptions;

use App\Store;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\Request;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Subscriptions\Subscriber;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class StoreUpdated extends GraphQLSubscription
{

    public function authorize(Subscriber $subscriber, Request $request): bool
    {
        // TODO implement authorize
        return true;
    }

    public function filter(Subscriber $subscriber, $root): bool
    {
        // TODO implement filter
        return true;
    }

    public function resolve($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Store
    {
        return $root;
    }
}
