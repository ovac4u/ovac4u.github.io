<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Phone extends GraphQLType
{
    protected $attributes = [
        'name' => 'Phone',
        'description' => 'A type',
        // 'model' => UserPhone::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user\'s phone.',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user\'s.',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'The phone of number',
            ],
            'country' => [
                'type' => Type::string(),
                'description' => 'The phone country.',
            ],
            'verified_at' => [
                'type' => Type::string(),
                'description' => 'The date and time when the phone number was verified.',
                'alias' => 'verified',
            ],

            //Relationships
            'user' => [
                'type' => GraphQL::type('user'),
                'description' => 'The user that owns the phone.',
            ],
        ];
    }
}
