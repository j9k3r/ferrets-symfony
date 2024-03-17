<?php

namespace App\Users\Infrastructure\Controller;

use App\Shared\Domain\Security\UserFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users/me', methods: ['GET'])]
class GetMeAction
{
    public function __construct(private readonly UserFetcherInterface $userFetcher)
    {
    }

    public function __invoke()
    {
//        return new JsonResponse([
//            'hello' => 'world',
//        ]);
        $user = $this->userFetcher->getAuthUser();

//        var_dump($user);die();
        return new JsonResponse([
            'ulid' => $user->getUlid(),
            'email' => $user->getEmail()
        ]);
    }
}