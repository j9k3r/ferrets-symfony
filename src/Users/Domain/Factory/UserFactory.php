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
//        if (count($roles) === 0) {
//            $makeRoles[] = 'ROLE_USER';
//        }


        $user->setRoles(array_merge($makeRoles, $roles));


        return $user;
    }

    public function update(string $email, array $roles): User
    {
        $user = new User($email);


        $user->setPassword($password, $this->passwordHasher);

        $makeRoles = ['ROLE_USER'];
//        if (count($roles) === 0) {
//            $makeRoles[] = 'ROLE_USER';
//        }


        $user->setRoles(array_merge($makeRoles, $roles));


        return $user;
    }
    public function updateRoles(User $user, array $roles): User
    {
//        $user = new User($email);


//        $user->setPassword($password, $this->passwordHasher);

//        $makeRoles = ['ROLE_USER'];
//        if (count($roles) === 0) {
//            $makeRoles[] = 'ROLE_USER';
//        }
//        dd($user);

        $user->setRoles($roles);


        return $user;
    }
}