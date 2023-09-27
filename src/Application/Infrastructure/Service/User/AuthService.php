<?php

namespace App\Infrastructure\Service\User;

use App\Domain\ValueObject\Email;
use App\Infrastructure\Exception\BadRequestException;
use App\Infrastructure\Repository\User\UserTokenRepository;
use App\Infrastructure\Security\ApiKeyAuthenticator;
use App\Infrastructure\Repository\User\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
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
    private UserTokenRepository $userTokenRepository;

    public function __construct(
        UserRepository $userRepository,
        ApiKeyAuthenticator $apiKeyAuthenticator,
        CreateTokenService $createTokenService,
        UserTokenRepository $userTokenRepository
    ){
        $this->userRepository = $userRepository;
        $this->apiKeyAuthenticator = $apiKeyAuthenticator;
        $this->createTokenService = $createTokenService;
        $this->userTokenRepository = $userTokenRepository;
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
            throw new UserNotFoundException();
        }
        $token = $this->apiKeyAuthenticator->createToken($passport, 'api');
        $hash = password_hash($token, PASSWORD_ARGON2I);
        $userToken = $this->createTokenService->create($passport->getUser(), $hash, 'api');

        return $userToken->getToken();  
    }

    public function deleteUserTokenHash(string $hash): void
    {
        $this->userTokenRepository->remove($hash, true);
    }
}