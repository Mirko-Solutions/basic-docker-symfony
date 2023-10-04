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
    private string $dateFormat;
    
    public function __construct(ManagerRegistry $registry, UserTokenRepository $userTokenRepository, string $dateFormat)
    {
        parent::__construct($registry, User::class);
        $this->userTokenRepository = $userTokenRepository;
        $this->dateFormat = $dateFormat;
    }

    public function findByEmail(Email $email): User|null
    {
        return $this->findOneBy(['email' => $email->toString()]);
    }

    public function findByEmailExlUserId(Email $email, int $userId): User|null
    {
        $qb = $this->createQueryBuilder('u');

        $user = $qb
            ->andWhere($qb->expr()->neq('u.id', ':excluded_id'))
            ->andWhere($qb->expr()->eq('u.email', ':email'))
            ->setParameter('excluded_id', $userId)
            ->setParameter('email', $email->toString())
            ->getQuery()
            ->getOneOrNullResult();

        if ($user === null) {
            throw new \Exception("User not found for email {$email} and user ID {$userId}");
        }

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

    public function softDelete(int $id): void
    {
        $qb = $this->createQueryBuilder('u');
        $qb->update(User::class,'u')
            ->set('u.deletedAt', ':deletedAt')
            ->where("u.id = :user_id")
            ->setParameter("deletedAt", (new \DateTime())->format($this->dateFormat))
            ->setParameter("user_id", $id)
            ->getQuery()
            ->execute();
    }
}
