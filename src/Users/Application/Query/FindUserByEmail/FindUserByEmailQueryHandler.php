<?php

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;


class FindUserByEmailQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(FindUserByEmailQuery $query): UserDTO
    {
        $user = $this->userRepository->findByEmail($query->email);
        if (!$user) {
//            return NULL; //Todo Правильнее возвращать Null ?
            throw new \Exception('user not found');
        }

        return UserDTO::fromEntity($user);
    }
}