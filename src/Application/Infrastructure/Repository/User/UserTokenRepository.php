<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\Entity\User\UserToken;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    public function add(UserToken $userToken, bool $flush = false): void
    {
        $this->getEntityManager()->persist($userToken);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
