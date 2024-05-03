<?php

namespace App\Users\Infrastructure\Security;

use App\Users\Domain\Entity\User as AppUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
//        $Tst = 'asd';
        dd('123');
//        throw new CustomUserMessageAccountStatusException('SsSSs');
//        throw new AccountExpiredException('...');
//         new JsonResponse(['status' => 'Sssss']);

    }

    public function checkPostAuth(UserInterface $user): void
    {
        // TODO: Implement checkPostAuth() method.
    }
}