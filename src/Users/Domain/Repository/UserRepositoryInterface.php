<?php

namespace App\Users\Domain\Repository;

use App\Users\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function update(User $user): void;

    public function findByUlid(string $ulid) :User;
    public function findByEmail(string $email): ?User;
}