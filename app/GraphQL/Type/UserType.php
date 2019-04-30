<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user',
        // 'model' => User::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
                'alias' => 'user_id', // Use 'alias', if the database column is different from the type name
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of user',
            ],
            'first_name' => [
                'type' => Type::string(),
                'description' => 'The first name of the user.',
            ],
            'last_name' => [
                'type' => Type::string(),
                'description' => 'The last name of the user.',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The user\'s full name.',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of the user.',
            ],
            'country' => [
                'type' => Type::string(),
                'description' => 'The user\'s country',
            ],
            'dob' => [
                'type' => Type::string(),
                'description' => 'The user\'s date of birth.',
            ],
            'username' => [
                'type' => Type::string(),
                'description' => 'The user\'s username.',
            ],
            'email_verified_at' => [
                'type' => Type::string(),
                'description' => 'The date/time when the email was verified.',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The user\'s registration date.',
            ],

            //Relationships
            'phones' => [
                'type' => Type::listOf(GraphQL::type('phone')),
                'description' => 'The user\'s phone numbers.',
            ],
        ];
    }
}
