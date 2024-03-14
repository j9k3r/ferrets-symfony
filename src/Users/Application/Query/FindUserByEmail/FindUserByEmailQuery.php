<?php

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryInterface;

class FindUserByEmailQuery implements QueryInterface
{
//    public function __construct(public readonly string $email, public readonly string $password)
    public function __construct(public readonly string $email)
    {
    }
}