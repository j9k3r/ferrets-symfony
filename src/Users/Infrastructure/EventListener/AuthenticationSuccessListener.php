<?php
namespace App\Users\Infrastructure\EventListener;

use App\Users\Domain\Entity\User as AuthUser;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Shared\Domain\Entity\RefreshToken;
//use App\Entity\RefreshToken;

class AuthenticationSuccessListener
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof AuthUser) {
            return;
        }
        $userEmail = $user->getEmail();

        $refreshTokenRepository = $this->em->getRepository(RefreshToken::class);
        $refreshTokens = $refreshTokenRepository->findBy(['username' => $userEmail], ['valid' => 'DESC']);

        //array_shift($refreshTokens);

        foreach ($refreshTokens as $refreshToken) {
            $this->em->remove($refreshToken);
        }

        $this->em->flush();

        $event->setData($data);
    }
}
