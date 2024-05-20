<?php
namespace App\Users\Infrastructure\Security;



use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use Symfony\Component\HttpFoundation\Response;
class CustomGuardAuthenticator extends JWTAuthenticator
{

    private $translator;
    private $eventDispatcher;

    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $eventDispatcher,
        TokenExtractorInterface $tokenExtractor,
        UserProviderInterface $userProvider,
        TranslatorInterface $translator = null
    ) {
        parent::__construct($jwtManager, $eventDispatcher, $tokenExtractor, $userProvider, $translator);
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
    }


//public function supports(Request $request): ?bool
//{
//    dd('extr');
//    return false !== $this->getTokenExtractor()->extract($request);
//}

    protected function loadUser(array $payload, string $identity): UserInterface
    {
        /** @var UserInterface|User $user */
        $user  = parent::loadUser($payload, $identity);
        if ($user->getBlocked()){
//            $ex = new UserNotFoundException('Your account has been deactivated by the administrators');
//            $ex->setUserIdentifier($identity);
//            throw $ex;
            $exception = new AuthenticationException("Your account has been deactivated by the administrators", 403);
            throw $exception;
        }
        return $user;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
//        dd('123');
        return null;

    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
//        $errorMessage = strtr($exception->getMessageKey(), $exception->getMessageData());
        $errorMessage = $exception->getMessage();

        $errorCode = $exception->getCode();

        if (null !== $this->translator) {
            $errorMessage = $this->translator->trans($exception->getMessageKey(), $exception->getMessageData(), 'security');
        }

        if (!empty($errorCode)) {
            $response = new JWTAuthenticationFailureResponse($errorMessage, $errorCode);
        } else {
            $response = new JWTAuthenticationFailureResponse($errorMessage);
        }

        if ($exception instanceof ExpiredTokenException) {
            $event = new JWTExpiredEvent($exception, $response, $request);
            $eventName = Events::JWT_EXPIRED;
        } else {
            $event = new JWTInvalidEvent($exception, $response, $request);
            $eventName = Events::JWT_INVALID;
        }

        $this->eventDispatcher->dispatch($event, $eventName);

        return $event->getResponse();
    }
}