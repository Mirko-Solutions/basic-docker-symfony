<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
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

    public function findByEmail(Email $email): User|null
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findByEmailExlUserId(Email $email, int $userId): User|null
    {
        $qb = $this->createQueryBuilder('u');

        $user = $qb
            ->andWhere($qb->expr()->neq('u.id', ':excluded_id'))
            ->andWhere($qb->expr()->eq('u.email', ':email'))
            ->setParameter('excluded_id', $userId)
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }

    public function add(User $user, bool $flush = false): void
    {
        $this->getEntityManager()->persist($user);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByToken(string $token): User|null
    {
        return $this->userTokenRepository->findOneBy(['token' => $token])?->user();
    }


    public function findByRecoveryToken(string $recoveryToken): User|null
    {
        return $this->findOneBy(['recoveryToken' => $recoveryToken]);
    }

    public function softDelete(User $user): void
    {
        $user->setDeletedAt();
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
