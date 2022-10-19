<?php

namespace App\Infrastructure\Service\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserToken;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Exception\BadRequestException;
use App\Infrastructure\Repository\User\UserRepository;
use App\Security\ApiKeyAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    public function auth(array $data)
    {
        $passport = new Passport(
            new UserBadge($data['email'], 
            function (string $userIdentifier)  {
                $eml = new Email($userIdentifier);
                return $this->userRepository->findByEmail($eml);
            }),
            new PasswordCredentials($data['password'])
        );

        $token = $this->apiKeyAuthenticator->createToken($passport, 'api');
        $hash = hash('sha256', $token);
        $this->createTokenService->create($passport->getUser(), $hash, 'api');
        return $hash; 
        
    }
}