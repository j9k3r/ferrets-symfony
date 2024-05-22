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

    public function __invoke(Request $request) //Todo доделать установку ролей
    {
//        dd('this delete');
        $user = $this->userFetcher->getAuthUser();
        $req = json_decode($request->getContent());

        $roles = $user->getRoles();
        $deleteRoles = $req->roles;
//        $mergedRoles = array_unique(array_merge($roles, $deleteRoles));


        if (in_array("ROLE_ADMIN", $roles)) {
//        dd($request->getContent());
//        dd($request->getPayload()->get('roles'));

            $userUpdate = $this->userRepository->findByEmail($req->email);
//            $userUpdateRoles = $userUpdate->getRoles();
//            $mergedRoles = array_unique(array_merge($userUpdateRoles, $deleteRoles));
//        dd($mergedRoles);

//        dd($userUpdate);

            $updUser = $this->userFactory->removeRoles($userUpdate, $deleteRoles);
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