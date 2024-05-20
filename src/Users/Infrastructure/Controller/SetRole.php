<?php

namespace App\Users\Infrastructure\Controller;

use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users/role', methods: ['POST'])]
class SetRole
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory){}

    public function __invoke(Request $request) //Todo доделать установку ролей
    {
        $user = $this->userFetcher->getAuthUser();
        $req = json_decode($request->getContent());

        $roles = $user->getRoles();
        $newRoles =  $req->roles;
//        $mergedRoles = array_unique(array_merge($roles, $newRoles));



        if (in_array("ROLE_ADMIN", $roles)) {
//        dd($request->getContent());
//        dd($request->getPayload()->get('roles'));

            $userUpdate = $this->userRepository->findByEmail($req->email);
            $userUpdateRoles = $userUpdate->getRoles();
            $mergedRoles = array_unique(array_merge($userUpdateRoles, $newRoles));
//        dd($mergedRoles);

//        dd($userUpdate);

            $updUser = $this->userFactory->updateRoles($userUpdate, $mergedRoles);
            $this->userRepository->add($updUser);

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