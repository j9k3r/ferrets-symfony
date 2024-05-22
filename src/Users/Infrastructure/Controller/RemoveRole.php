<?php

namespace App\Users\Infrastructure\Controller;

use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users/role', methods: ['DELETE'])]
class RemoveRole
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory){}

    public function __invoke(Request $request)
    {
        $user = $this->userFetcher->getAuthUser();
        $req = json_decode($request->getContent());

        $roles = $user->getRoles();
        $deleteRoles = $req->roles;

        if (in_array("ROLE_ADMIN", $roles)) {
            $userUpdate = $this->userRepository->findByEmail($req->email);
            $updUser = $this->userFactory->removeRoles($userUpdate, $deleteRoles);
            $this->userRepository->update($updUser);

            return new JsonResponse([
                'email' => $updUser->getEmail(),
                'roles' => $updUser->getRoles()
            ]);
        }
        return new JsonResponse([
            'msg' => 'access is denied, not enough rights'
        ], 403);
    }
}