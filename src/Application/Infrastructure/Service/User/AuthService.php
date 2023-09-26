<?php

namespace App\Infrastructure\Service\User;

use App\Domain\ValueObject\Email;
use App\Infrastructure\Exception\BadRequestException;
use App\Infrastructure\Security\ApiKeyAuthenticator;
use App\Infrastructure\Repository\User\UserRepository;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class AuthService
{
    private $userRepository;
    private $apiKeyAuthenticator;
    private $createTokenService;

    public function __construct(
        UserRepository $userRepository,
        ApiKeyAuthenticator $apiKeyAuthenticator,
        CreateTokenService $createTokenService
    ){
        $this->userRepository = $userRepository;
        $this->apiKeyAuthenticator = $apiKeyAuthenticator;
        $this->createTokenService = $createTokenService;
    }

    public function createUserTokenHash(string $idendtifier, string $password)
    {
        $passport = new Passport(
            new UserBadge($idendtifier, 
            function (string $userIdentifier)  {
                return $this->userRepository->findByEmail(new Email($userIdentifier));
            }),
            new PasswordCredentials($password)
        );
        $passwordIsValid = null;
        if ($passport->getUser() && null === $passport->getUser()->getDeletedAt()) {
            $passwordIsValid = password_verify($password, $passport->getUser()->getPassword());
        }
        if (!$passwordIsValid) {
            // Password is invalid
            throw new BadRequestException('User not found');
        }
        $token = $this->apiKeyAuthenticator->createToken($passport, 'api');
        $hash = password_hash($token, PASSWORD_ARGON2I);
        $userToken = $this->createTokenService->create($passport->getUser(), $hash, 'api');

        return $userToken->getToken();  
    }
}