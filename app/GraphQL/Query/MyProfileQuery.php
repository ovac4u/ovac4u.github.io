<?php

namespace App\GraphQL\Query;

use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class MyProfileQuery extends Query
{
    protected $attributes = [
        'name' => 'MyProfileQuery',
        'description' => 'A query',
    ];

    public function type()
    {
        return GraphQL::type('user');
    }

    public function args()
    {
        return [

        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        // $select = $fields->getSelect();
        // $with = $fields->getRelations();

        return User::first();
    }
}
