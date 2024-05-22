<?php

namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;

class UserFactory
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(string $email, string $password, array $roles): User
    {
        $user = new User($email);
        $user->setPassword($password, $this->passwordHasher);

        $makeRoles = ['ROLE_USER'];
        $user->addRoles(array_merge($makeRoles, $roles));

        return $user;
    }

    public function update(string $email, array $roles): User
    {
        $user = new User($email);
        $user->setPassword($password, $this->passwordHasher);
        $makeRoles = ['ROLE_USER'];
        $user->addRoles(array_merge($makeRoles, $roles));

        return $user;
    }
    public function addRoles(User $user, array $roles): User
    {
        $user->addRoles($roles);
        return $user;
    }

    public function removeRoles(User $user, array $roles): User
    {
        foreach ($roles as $role) {
            $user->removeRole($role);
        }

        return $user;
    }
}