<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class UserRepository extends ServiceEntityRepository
{
    private UserTokenRepository $userTokenRepository;
    
    public function __construct(ManagerRegistry $registry, UserTokenRepository $userTokenRepository)
    {
        parent::__construct($registry, User::class);
        $this->userTokenRepository = $userTokenRepository;
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function add(User $user, bool $flush = false): void
    {
        $this->getEntityManager()->persist($user);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByToken(string $token): ?User
    {
        return $this->userTokenRepository->findOneBy(['token' => $token])?->getUser();
    }

    public function findByRecoveryToken(string $token): ?User
    {
        return $this->findOneBy(['recoveryToken' => $token]);
    }
}
