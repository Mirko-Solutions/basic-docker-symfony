<?php

namespace App\Infrastructure\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Repository\User\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    const API_LOGIN_PATH = '/api/user/login';
    public const API_REGISTER_PATH = '/api/user/register';
    public const API_RECOVERY_PATH = '/api/user/recovery';
    public const API_RESET_PASSWORD_PATH = '/api/user/reset-password';
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request): ?bool
    {
        $pathInfo = $request->getPathInfo();
        foreach ([
                     self::API_LOGIN_PATH,
                     self::API_REGISTER_PATH,
                     self::API_RECOVERY_PATH,
                     self::API_RESET_PASSWORD_PATH,
                 ] as $prefix) {
            if (str_starts_with($pathInfo, $prefix)) {
                return false;
            }
        }

        return str_starts_with($pathInfo, '/api/');
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get('X-AUTH-TOKEN');
        if (null === $apiToken) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        return new SelfValidatingPassport(new UserBadge($apiToken, function ($apiToken) {
            $user = $this->userRepository->findByToken($apiToken);
            if (!$user) {
                throw new UserNotFoundException();
            }
            return $user;
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw $exception;
    }
}
