<?php

namespace App\Shared\Infrastructure\Security;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use Webmozart\Assert\Assert;
use Symfony\Bundle\SecurityBundle\Security;

class UserFetcher implements UserFetcherInterface
{

    public function __construct(private readonly Security $security)
    {
    }

    public function getAuthUser(): AuthUserInterface
    {
        /** @var AuthUserInterface $user */
        $user = $this->security->getUser();

        Assert::notNull($user, 'current user not found check security access list');
        Assert::isInstanceOf($user, AuthUserInterface::class, sprintf('invalid user type %s', get_class($user)));

        return $user;
    }
}